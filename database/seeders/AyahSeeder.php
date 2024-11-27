<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use MongoDB\Client as MongoClient;

class AyahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define the collection name
        $collectionName = 'ayahs';

        createDatabaseCollection($collectionName);

        $client = new MongoClient(env('DB_URI'));
        $database = $client->selectDatabase(env('DB_DATABASE'));
        $collection = $database->selectCollection($collectionName);

        // Define your indexes (composite or single) with collation and unique options
        $indexesToCreate = [
            [
                'fields' => ['page_id' => 1, 'ayah_key' => 1], // Index fields
                'collation' => [
                    'locale' => 'en',
                    'numericOrdering' => true,
                ],
                'unique' => true, // Unique
            ],
            [
                'fields' => ['juz_id' => 1, 'ayah_key' => 1], // Index fields
                // 'collation' => null, // No collation (default collation)
                'collation' => [
                    'locale' => 'en',
                    'numericOrdering' => true,
                ],
                'unique' => true, // Unique
            ],
            [
                'fields' => ['ayah_key' => 1], // Index fields
                'collation' => [
                    'locale' => 'en',
                    'numericOrdering' => true,
                ],
                'unique' => true, // Unique
            ],
        ];

        // Get existing indexes
        $existingIndexes = $collection->listIndexes();
        $existingIndexNames = [];

        // Store existing index names
        foreach ($existingIndexes as $index) {
            $existingIndexNames[] = $index->getName();
        }

        // Loop through your desired indexes and create them if they do not exist
        foreach ($indexesToCreate as $indexConfig) {
            $indexFields = $indexConfig['fields'];
            $collation = $indexConfig['collation'];
            $unique = $indexConfig['unique'];

            // Generate a unique index name based on the fields
            $indexName = implode('_', array_keys($indexFields));

            // Check if the index already exists
            if (!in_array($indexName, $existingIndexNames)) {
                $options = [
                    'name' => $indexName,
                    'unique' => $unique, // Apply unique constraint if specified
                ];

                // Add collation to the options if it exists
                if ($collation) {
                    $options['collation'] = $collation;
                }

                // Create the index
                $collection->createIndex($indexFields, $options);
            }
        }

        $filePathAya = Storage::url('quran-data/quran-uthmani.xml');
        $filePathPage = Storage::url('quran-data/quran-data.xml');

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

        // Parse juzs and create a lookup table
        $juzs = [];
        foreach ($xmlPage->juzs->juz as $juz) {
            $juzs[] = [
                'index' => (int) $juz['index'],
                'sura' => (int) $juz['sura'],
                'aya' => (int) $juz['aya'],
            ];
        }

        foreach ($xmlAya->sura as $sura) {
            foreach ($sura->aya as $aya) {
                $suraIndex = (int) $sura['index'];
                $ayaIndex = (int) $aya['index'];

                $pageIndex = $this->getPageIndex($pages, $suraIndex, $ayaIndex);
                $juzIndex = $this->getJuzIndex($juzs, $suraIndex, $ayaIndex);

                DB::table($collectionName)->insert([
                    '_id' => (string) getNextSequenceValue('ayah_id'),
                    'page_id' => (string) $pageIndex,
                    'juz_id' => (string) $juzIndex,
                    'surah_id' => (string) $suraIndex,
                    'ayah_index' => (string) $ayaIndex,
                    'ayah_key' => (string) $suraIndex . ':' . $ayaIndex,
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

    /**
     * Get the page index for a given sura and aya index.
     */
    private function getJuzIndex(array $juzs, int $suraIndex, int $ayaIndex)
    {
        $juzIndex = null;

        // Traverse the juzs in reverse order to find the first page that is less than or equal to the current ayah
        for ($i = count($juzs) - 1; $i >= 0; $i--) {
            if ($juzs[$i]['sura'] < $suraIndex || ($juzs[$i]['sura'] == $suraIndex && $juzs[$i]['aya'] <= $ayaIndex)) {
                $juzIndex = $juzs[$i]['index'];
                break;
            }
        }

        return $juzIndex;
    }
}
