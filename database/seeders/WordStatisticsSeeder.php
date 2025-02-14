<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use MongoDB\Client as MongoClient;

class WordStatisticsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define the collection name
        $collectionName = 'word_statistics';

        createDatabaseCollection($collectionName); // Ensure collection exists

        $client = new MongoClient(env('DB_URI'));
        $database = $client->selectDatabase(env('DB_DATABASE'));
        $collection = $database->selectCollection($collectionName);

        // Define indexes to optimize queries
        $indexesToCreate = [
            [
                'fields' => ['word' => 1],
                'unique' => false,
            ],
            [
                'fields' => ['total_occurrences' => -1], // Sorting for stats
                'unique' => false,
            ]
        ];

        // Get existing indexes
        $existingIndexes = $collection->listIndexes();
        $existingIndexNames = [];

        foreach ($existingIndexes as $index) {
            $existingIndexNames[] = $index->getName();
        }

        // Create indexes if they don’t exist
        foreach ($indexesToCreate as $indexConfig) {
            $indexFields = $indexConfig['fields'];
            $unique = $indexConfig['unique'];
            $indexName = implode('_', array_keys($indexFields));

            if (!in_array($indexName, $existingIndexNames)) {
                $options = ['name' => $indexName, 'unique' => $unique];
                $collection->createIndex($indexFields, $options);
            }
        }

        // Fetch words collection data
        $wordsCollection = $database->selectCollection('words');
        $words = $wordsCollection->find();

        $wordStatistics = [];

        foreach ($words as $wordData) {

            if ($this->isWaqafOrSymbol($wordData)) {
                continue;
            }
            
            $word = $wordData['text'];

            if (!isset($wordStatistics[$word])) {
                $wordStatistics[$word] = [
                    '_id' => getNextSequenceValue('word_statistics_id'),
                    'word' => $word,
                    'transliteration' => $wordData['transliteration'] ?? null,
                    'translation' => $wordData['translation'] ?? null,
                    'characters' => $wordData['characters'] ?? [],
                    'total_occurrences' => 0,
                    'occurrences_by_surah' => [],
                    'occurrences_by_juz' => [],
                    'occurrences_by_page' => [],
                    'positions' => [
                        'word_keys' => [],
                        'page_positions' => [],
                    ]
                ];
            }

            // Increment total occurrences
            $wordStatistics[$word]['total_occurrences']++;

            // Track occurrences by Surah
            $surahId = (int) $wordData['surah_id'];
            if (!isset($wordStatistics[$word]['occurrences_by_surah'][$surahId])) {
                $wordStatistics[$word]['occurrences_by_surah'][$surahId] = 1;
            } else {
                $wordStatistics[$word]['occurrences_by_surah'][$surahId]++;
            }

            // Track occurrences by Juz
            $juzId = (int) $wordData['juz_id'];
            if (!isset($wordStatistics[$word]['occurrences_by_juz'][$juzId])) {
                $wordStatistics[$word]['occurrences_by_juz'][$juzId] = 1;
            } else {
                $wordStatistics[$word]['occurrences_by_juz'][$juzId]++;
            }

            // Track occurrences by Page
            $pageId = (int) $wordData['page_id'];
            if (!isset($wordStatistics[$word]['occurrences_by_page'][$pageId])) {
                $wordStatistics[$word]['occurrences_by_page'][$pageId] = 1;
            } else {
                $wordStatistics[$word]['occurrences_by_page'][$pageId]++;
            }

            // Store positions
            $wordKey = $wordData['word_key'];
            $wordStatistics[$word]['positions']['word_keys'][] = $wordKey;

            // Track positions by page & line number
            $lineNumber = (int) $wordData['line_number'];
            $pagePositions = &$wordStatistics[$word]['positions']['page_positions'];

            $existingPageIndex = array_search($pageId, array_column($pagePositions, 'page_id'));

            if ($existingPageIndex !== false) {
                $pagePositions[$existingPageIndex]['total_count']++;

                $lineIndex = array_search($lineNumber, array_column($pagePositions[$existingPageIndex]['lines'], 'line_number'));
                if ($lineIndex !== false) {
                    $pagePositions[$existingPageIndex]['lines'][$lineIndex]['count']++;
                } else {
                    $pagePositions[$existingPageIndex]['lines'][] = ['line_number' => $lineNumber, 'count' => 1];
                }
            } else {
                $pagePositions[] = [
                    'page_id' => $pageId,
                    'total_count' => 1,
                    'lines' => [['line_number' => $lineNumber, 'count' => 1]]
                ];
            }
        }

        // Insert into MongoDB
        foreach ($wordStatistics as $stats) {
            $stats['occurrences_by_surah'] = array_map(
                fn($count, $id) => ['surah_id' => $id, 'count' => $count],
                $stats['occurrences_by_surah'],
                array_keys($stats['occurrences_by_surah'])
            );

            $stats['occurrences_by_juz'] = array_map(
                fn($count, $id) => ['juz_id' => $id, 'count' => $count],
                $stats['occurrences_by_juz'],
                array_keys($stats['occurrences_by_juz'])
            );

            $stats['occurrences_by_page'] = array_map(
                fn($count, $id) => ['page_id' => $id, 'count' => $count],
                $stats['occurrences_by_page'],
                array_keys($stats['occurrences_by_page'])
            );

            $collection->insertOne($stats);
        }
    }

    private function isWaqafOrSymbol($wordData): bool 
    {
        // Check for null/empty characters
        if (empty($wordData['characters'])) {
            return true;
        }

        // Check if translation is just a number in parentheses
        if (preg_match('/^\(\d+\)$/', $wordData['translation'])) {
            return true;
        }

        // Check if text is a single special character
        if (mb_strlen($wordData['text']) === 1 && empty($wordData['transliteration'])) {
            return true;
        }

        return false;
    }
}
