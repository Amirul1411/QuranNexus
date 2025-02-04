<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use MongoDB\Client as MongoClient;

class LongestTokenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define the collection name
        $collectionName = 'longest_token';

        createDatabaseCollection($collectionName);

        $client = new MongoClient(env('DB_URI'));
        $database = $client->selectDatabase(env('DB_DATABASE'));
        $collection = $database->selectCollection($collectionName);

        // Define your indexes (composite or single) with collation and unique options
        $indexesToCreate = [
            [
                'fields' => ['ayah_key' => 1], // Index fields
                'collation' => [
                    'locale' => 'en',
                    'numericOrdering' => true,
                ],
                'unique' => false, // Unique
            ],
            [
                'fields' => ['word_key' => 1], // Index fields
                'collation' => [
                    'locale' => 'en',
                    'numericOrdering' => true,
                ],
                'unique' => true, // Not unique
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

        try {
            require 'http://localhost:8080/JavaBridge/java/Java.inc';

            // Get tokens from the Document class
            $document = new \Java('org.jqurantree.orthography.Document');
            $tokens = $document->getTokens();

            // Array to store tokens of target letter count
            // Longest token in the whole quran has a letter count of 11
            $targetLetterCount = [8, 9, 10, 11];

            // Iterate over tokens and find those matching target lengths
            $tokenIterator = $tokens->iterator();
            while (java_is_true($tokenIterator->hasNext())) {
                $token = $tokenIterator->next();
                $tokenLength = java_cast($token->getLetterCount(), 'int');

                if (in_array($tokenLength, $targetLetterCount)) {
                    DB::table($collectionName)->insert([
                        '_id' => (string) getNextSequenceValue('longest_token_id'),
                        'surah_id' => (string) $token->getChapterNumber(),
                        'ayah_index' => (string) $token->getVerseNumber(),
                        'word_index' => (string) $token->getTokenNumber(),
                        'ayah_key' => (string) $token->getChapterNumber() . ':' . $token->getVerseNumber(),
                        'word_key' => (string) $token->getChapterNumber() . ':' . $token->getVerseNumber() . ':' . $token->getTokenNumber(),
                        'text' => (string) $token->toUnicode(),
                        'length' => (int) $tokenLength,
                    ]);
                }
            }

            // Convert results into the required rows format
        } catch (\JavaException $e) {
            echo 'Java Exception: ' . $e->getMessage();
            echo 'Stack Trace: ' . $e->getTraceAsString();
        }
    }
}
