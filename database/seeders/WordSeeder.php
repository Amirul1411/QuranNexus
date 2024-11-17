<?php

namespace Database\Seeders;

use App\Models\Ayah;
use App\Models\Page;
use App\Models\Word;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use MongoDB\Client as MongoClient;

class WordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $collectionName = 'words';

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

        // Seed database from jQuranTree

        // Include the JavaBridge library
        require 'http://localhost:8080/JavaBridge/java/Java.inc';

        $countCurrent = Word::count();
        $count = 1;

        try {
            // Create an instance of the Document class
            $document = new \Java('org.jqurantree.orthography.Document');

            // Call the getChapters method
            $tokensIterable = $document->getTokens();

            if ($tokensIterable instanceof \Java) {
                $iterator = $tokensIterable->iterator(); // Get an iterator

                while (java_is_true($iterator->hasNext())) {
                    $token = $iterator->next();

                    if ($count <= $countCurrent) {
                        $count++;
                        continue;
                    }

                    $ayah = Ayah::where('surah_id', (string) $token->getChapterNumber())->where('ayah_index', (string) $token->getVerseNumber())->first();

                    $page = $ayah->page;

                    // $tokenVerseKey = (string) $token->getChapterNumber() . ':' . (string) $token->getVerseNumber() . PHP_EOL;

                    $response = Http::timeout(60)
                        ->retry(3, 1000)
                        ->get('https://api.quran.com/api/v4/verses/by_page/' . $page->id . '?words=true');
                    // $jsonContent = $response->json();
                    // echo json_encode($jsonContent, JSON_PRETTY_PRINT);

                    // Extract JSON data from the response
                    $data = $response->json();

                    // Loop through verses
                    foreach ($data['verses'] as $verse) {
                        // Access the verse_key property
                        $verseKey = $verse['verse_key'];

                        // Split the verse_key (e.g., "2:6") into surah_number and verse_number
                        [$surahNumber, $verseNumber] = explode(':', $verseKey);

                        // Loop through words within each verse
                        foreach ($verse['words'] as $word) {
                            // Access the position property
                            $wordPosition = $word['position'];

                            if ((string) $surahNumber === (string) $token->getChapterNumber() && (string) $verseNumber === (string) $token->getVerseNumber() && (string) $wordPosition === (string) $token->getTokenNumber()) {
                                $pageLineNumber = $word['line_number'];
                                $translation = $word['translation']['text'];
                                $transliteration = $word['transliteration']['text'];

                                // Construct the expected audio URL format based on surah, verse, and word position
                                $expectedAudioUrl = sprintf('wbw/%03d_%03d_%03d.mp3', $surahNumber, $verseNumber, $wordPosition);

                                // Check if the actual audio URL matches the expected format
                                if ($word['audio_url'] === $expectedAudioUrl) {
                                    $audioUrl = $word['audio_url'];
                                } else {
                                    // Overwrite with the correct audio URL if it does not match the expected format
                                    $audioUrl = $expectedAudioUrl;
                                }

                                // echo 'Page Number: ' . $word['page_number'] . PHP_EOL;
                                // echo 'Line Number: ' . $pageLineNumber . PHP_EOL;
                                break 2;
                            }
                        }
                    }

                    DB::table($collectionName)->insert([
                        '_id' => (string) getNextSequenceValue('word_id'),
                        'surah_id' => (string) $token->getChapterNumber(),
                        'ayah_index' => (string) $token->getVerseNumber(),
                        'word_index' => (string) $token->getTokenNumber(),
                        'ayah_key' => (string) $token->getChapterNumber() . ':' . $token->getVerseNumber(),
                        'word_key' => (string) $token->getChapterNumber() . ':' . $token->getVerseNumber() . ':' . $token->getTokenNumber(),
                        'audio_url' => (string) $audioUrl,
                        'page_id' => (string) $page->id,
                        'line_number' => (int) $pageLineNumber,
                        'text' => (string) $token,
                        'translation' => (string) $translation,
                        'transliteration' => (string) $transliteration,
                    ]);

                    $count++;
                }
            } else {
                echo 'The result from Java API is not an Iterable.';
            }
        } catch (\Exception $e) {
            echo 'Error accessing Java API: ' . $e->getMessage();
        }
    }
}
