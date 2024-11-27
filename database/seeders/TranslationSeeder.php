<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use MongoDB\Client as MongoClient;

class TranslationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Define the collection name
        $collectionName = 'translations';

        createDatabaseCollection($collectionName);

        $client = new MongoClient(env('DB_URI'));
        $database = $client->selectDatabase(env('DB_DATABASE'));
        $collection = $database->selectCollection($collectionName);

        // Define your indexes (composite or single) with collation and unique options
        $indexesToCreate = [
            [
                'fields' => ['translation_info_id' => 1, 'ayah_key' => 1], // Index fields
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

        $filePath = [Storage::url('quran-data\ms.basmeih.xml'), Storage::url('quran-data\en.sahih.xml')];

        foreach ($filePath as $file) {
            $xml = simplexml_load_file($file);

            foreach ($xml->sura as $sura) {
                foreach ($sura->aya as $aya) {
                    DB::table($collectionName)->insert([
                        '_id' => (string) getNextSequenceValue('translation_id'),
                        'translation_info_id' => (string) mapTranslationId($file),
                        'surah_id' => (string) $sura['index'],
                        'ayah_index' => (string) $aya['index'],
                        'ayah_key' => (string) $sura['index'] . ':' . $aya['index'],
                        'text' => (string) $aya['text'],
                    ]);
                }
            }
        }
    }
}
