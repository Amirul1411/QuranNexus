<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use MongoDB\Client as MongoClient;

class AudioRecitationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Define the collection name
        $collectionName = 'audio_recitations';

        createDatabaseCollection($collectionName);

        $client = new MongoClient(env('DB_URI'));
        $database = $client->selectDatabase(env('DB_DATABASE'));
        $collection = $database->selectCollection($collectionName);

        // Define your indexes (composite or single) with collation and unique options
        $indexesToCreate = [
            [
                'fields' => ['audio_info_id' => 1, 'ayah_key' => 1], // Index fields
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

        $recitationId = [7, 2];

        foreach ($recitationId as $id) {
            $response = Http::timeout(60)
                ->retry(3, 1000)
                ->get('https://api.quran.com/api/v4/quran/recitations/' . $id);
            $data = $response->json();

            foreach ($data['audio_files'] as $audio) {
                // Access the verse_key property
                $verseKey = $audio['verse_key'];

                // Split the verse_key (e.g., "2:6") into surah_number and verse_number
                [$surahNumber, $verseNumber] = explode(':', $verseKey);

                DB::table($collectionName)->insert([
                    '_id' => (string) getNextSequenceValue('audio_id'),
                    'audio_info_id' => (string) mapAudioRecitationId($id),
                    'surah_id' => (string) $surahNumber,
                    'ayah_index' => (string) $verseNumber,
                    'ayah_key' => (string) $surahNumber . ':' . $verseNumber,
                    'audio_url' => (string) $audio['url'],
                ]);
            }
        }
    }
}
