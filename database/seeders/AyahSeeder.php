<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AyahSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePathAya = resource_path('data/quran-uthmani.xml');
        $filePathPage = resource_path('data/quran-data.xml');

        $xmlAya = simplexml_load_file($filePathAya);
        $xmlPage = simplexml_load_file($filePathPage);

        // Parse pages and create a lookup table
        $pages = [];
        foreach ($xmlPage->pages->page as $page) {
            $pages[] = [
                'index' => (int) $page['index'],
                'sura' => (int) $page['sura'],
                'aya' => (int) $page['aya'],
            ];
        }

        foreach ($xmlAya->sura as $sura) {
            foreach ($sura->aya as $aya) {
                $suraIndex = (int) $sura['index'];
                $ayaIndex = (int) $aya['index'];

                $pageIndex = $this->getPageIndex($pages, $suraIndex, $ayaIndex);

                DB::table('ayahs')->insert([
                    '_id' => (string) getNextSequenceValue('ayah_id'),
                    'page_id' => (string) $pageIndex,
                    'surah_id' => (string) $suraIndex,
                    'ayah_index' => (string) $ayaIndex,
                    'bismillah' => isset($aya['bismillah']) ? (string) $aya['bismillah'] : null,
                    'text' => (string) $aya['text'],
                    'isVerified' => false,
                ]);
            }
        }
    }

    /**
     * Get the page index for a given sura and aya index.
     */
    private function getPageIndex(array $pages, int $suraIndex, int $ayaIndex)
    {
        $pageIndex = null;

        // Traverse the pages in reverse order to find the first page that is less than or equal to the current ayah
        for ($i = count($pages) - 1; $i >= 0; $i--) {
            if ($pages[$i]['sura'] < $suraIndex || ($pages[$i]['sura'] == $suraIndex && $pages[$i]['aya'] <= $ayaIndex)) {
                $pageIndex = $pages[$i]['index'];
                break;
            }
        }

        return $pageIndex;
    }
}
