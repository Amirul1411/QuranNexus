<?php

namespace Database\Seeders;

use App\Models\Ayah;
use App\Models\Tafseer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use MongoDB\Client as MongoClient;

class TafseerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define the collection name
        $collectionName = 'tafseer';

        createDatabaseCollection($collectionName);

        $client = new MongoClient(env('DB_URI'));
        $database = $client->selectDatabase(env('DB_DATABASE'));
        $collection = $database->selectCollection($collectionName);

        // Define your indexes (composite or single) with collation and unique options
        $indexesToCreate = [
            [
                'fields' => ['tafseer_info_id' => 1, 'ayah_key' => 1], // Index fields
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
                'unique' => false, // Not unique
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

        // $countTafseerCurrent = Tafseer::count();
        // $currentLastTafseer = null;
        // $countTafseerInfoIdCurrent = 0;

        // if($countTafseerCurrent > 0){
        //     $currentLastTafseer = Tafseer::find($countTafseerCurrent);
        //     $countTafseerInfoIdCurrent = (int) $currentLastTafseer->tafseer_info_id;
        // }

        // $countTafseer = 1;

        // $tafseerId = [160, 90];
        // $allAyahs = Ayah::all();

        // foreach ($tafseerId as $id) {

        //     if($countTafseerCurrent > 0 && $countTafseerInfoIdCurrent !==  (int) mapTafseerId($id)){
        //         continue;
        //     }

        //     foreach ($allAyahs as $ayah) {

        //         if ($countTafseerCurrent > 0 && $countTafseer <= ( $countTafseerCurrent % 6236 )) {
        //             $countTafseer++;
        //             continue;
        //         }

        //         $response = Http::timeout(60)
        //             ->retry(3, 1000)
        //             ->get('https://api.quran.com/api/v4/quran/tafsirs/' . $id . '?verse_key=' . $ayah->surah_id . ':' . $ayah->ayah_index);

        //         // Extract JSON data from the response
        //         $data = $response->json();
        //         $tafseers = $data['tafsirs'];

        //         foreach ($tafseers as $tafseer) {
        //             if ($tafseer['resource_id'] === mapTafseerResourceId($id)) {
        //                 $html = $tafseer['text'];
        //                 break;
        //             }
        //         }

        //         DB::table($collectionName)->insert([
        //             '_id' => (string) getNextSequenceValue('tafseer_id'),
        //             'tafseer_info_id' => (string) mapTafseerId($id),
        //             'surah_id' => (string) $ayah->surah_id,
        //             'ayah_index' => (string) $ayah->ayah_index,
        //             'ayah_key' => (string) $ayah->surah_id . ':' . $ayah->ayah_index,
        //             'html' => $html === "" ? null : $html,
        //         ]);
        //     }

        //     $countTafseerInfoIdCurrent++;

        // }
    }
}
