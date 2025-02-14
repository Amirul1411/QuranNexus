<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use MongoDB\Client as MongoClient;

class ChaptersInitialsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define the collection name
        $collectionName = 'chapters_initials';

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

        try {

            require 'http://localhost:8080/JavaBridge/java/Java.inc';

            $document = new \Java('org.jqurantree.orthography.Document');
            $tokensIterable = $document->getTokens(); // Replace this with your actual source for tokens
            $iterator = $tokensIterable->iterator();

            while (java_is_true($iterator->hasNext())) {

                $token = $iterator->next();
                $isValid = true;

                $tokenLength = java_cast($token->getLength(), 'int');

                // Check if the token contains only maddah or no diacritics
                for ($i = 0; $i < $tokenLength; $i++) {
                    $character = $token->getCharacter($i);

                    if (!java_cast($character->isMaddah(), 'boolean') && java_cast($character->getDiacriticCount(), 'int') != 0) {
                        $isValid = false;
                        break;
                    }
                }

                if ($isValid) {
                    $chapterNumber =  java_cast( $token->getChapterNumber(), 'string');
                    $verseLocation = java_Cast($token->getVerse()->getLocation(), 'string');
                    $verseLocation = str_replace(['(', ')'], '', $verseLocation);
                    $initials = java_cast($token->removeDiacritics()->toUnicode(), 'string');
                    DB::table($collectionName)->insert([
                        '_id' => (string) getNextSequenceValue('chapters_initials_id'),
                        'surah_id' => $chapterNumber,
                        'ayah_key' => $verseLocation,
                        'initials' => $initials,
                    ]);
                }
            }
        } catch (\JavaException $e) {
            echo 'Java Exception: ' . $e->getMessage();
            echo 'Stack Trace: ' . $e->getTraceAsString();
        }
    }
}
