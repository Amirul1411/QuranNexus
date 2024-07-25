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
        $filePath = resource_path('data\quran-data.xml');
        $filePathAya = resource_path('data\quran-uthmani.xml');

        $xml = simplexml_load_file($filePath);
        $xmlAya = simplexml_load_file($filePathAya);

        foreach ($xml->suras->sura as $sura) {
            foreach ($xmlAya->sura as $ayaSura) {
                if ((int) $sura['index'] == (int) $ayaSura['index']) {
                    foreach ($ayaSura->aya as $aya) {
                        if ($aya['bismillah']) {
                            DB::table('ayahs')->insert([
                                '_id' => (string) getNextSequenceValue('ayah_id'),
                                'surah_id' => (string) $sura['index'],
                                'ayah_index' => (string) $aya['index'],
                                'text' => (string) $aya['text'],
                                'bismillah' => (string) $aya['bismillah'],
                                'isVerified' => false,
                            ]);
                        } else {
                            DB::table('ayahs')->insert([
                                '_id' => (string) getNextSequenceValue('ayah_id'),
                                'surah_id' => (string) $sura['index'],
                                'ayah_index' => (string) $aya['index'],
                                'text' => (string) $aya['text'],
                                'bismillah' => '',
                                'isVerified' => false,
                            ]);
                        }
                    }
                }
            }
        }
    }
}
