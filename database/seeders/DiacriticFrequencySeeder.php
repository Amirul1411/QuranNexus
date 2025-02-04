<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use MongoDB\Client as MongoClient;

class DiacriticFrequencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define the collection name
        $collectionName = 'diacritic_frequency';

        createDatabaseCollection($collectionName);

        try {
            require 'http://localhost:8080/JavaBridge/java/Java.inc';

            // Get tokens from the Document class
            $document = new \Java('org.jqurantree.orthography.Document');
            $tokens = $document->getTokens();

            // Initialize diacritic frequency and locations array
            $diacriticData = [
                'Fatha' => ['count' => 0, 'locations' => []],
                'Damma' => ['count' => 0, 'locations' => []],
                'Kasra' => ['count' => 0, 'locations' => []],
                'Fathatan' => ['count' => 0, 'locations' => []],
                'Dammatan' => ['count' => 0, 'locations' => []],
                'Kasratan' => ['count' => 0, 'locations' => []],
                'Shadda' => ['count' => 0, 'locations' => []],
                'Sukun' => ['count' => 0, 'locations' => []],
                'Maddah' => ['count' => 0, 'locations' => []],
                'HamzaAbove' => ['count' => 0, 'locations' => []],
                'HamzaBelow' => ['count' => 0, 'locations' => []],
                'HamzatWasl' => ['count' => 0, 'locations' => []],
                'AlifKhanjareeya' => ['count' => 0, 'locations' => []],
            ];

            // Iterate over tokens and record diacritic frequencies and locations
            $tokenIterator = $tokens->iterator();

            while (java_is_true($tokenIterator->hasNext())) {
                $token = $tokenIterator->next();

                // Get the chapter and verse information for the token
                $chapterNumber = $token->getChapterNumber();
                $verseNumber = $token->getVerseNumber();
                $tokenNumber = $token->getTokenNumber();

                // Iterate over characters in the token
                $characterIterator = $token->iterator();
                $characterPosition = 0; // Track the character position within the token

                while (java_is_true($characterIterator->hasNext())) {
                    $character = $characterIterator->next();
                    $characterPosition++;

                    // Check for each diacritic and record its location
                    if (java_is_true($character->isFatha())) {
                        $diacriticData['Fatha']['count']++;
                        $diacriticData['Fatha']['locations'][] = [
                            'character_key' => (string) $chapterNumber . ':' . $verseNumber . ':' . $tokenNumber . ':' . $characterPosition,
                        ];
                    }

                    if (java_is_true($character->isDamma())) {
                        $diacriticData['Damma']['count']++;
                        $diacriticData['Damma']['locations'][] = [
                            'character_key' => (string) $chapterNumber . ':' . $verseNumber . ':' . $tokenNumber . ':' . $characterPosition,
                        ];
                    }

                    if (java_is_true($character->isKasra())) {
                        $diacriticData['Kasra']['count']++;
                        $diacriticData['Kasra']['locations'][] = [
                            'character_key' => (string) $chapterNumber . ':' . $verseNumber . ':' . $tokenNumber . ':' . $characterPosition,
                        ];
                    }

                    if (java_is_true($character->isFathatan())) {
                        $diacriticData['Fathatan']['count']++;
                        $diacriticData['Fathatan']['locations'][] = [
                            'character_key' => (string) $chapterNumber . ':' . $verseNumber . ':' . $tokenNumber . ':' . $characterPosition,
                        ];
                    }

                    if (java_is_true($character->isDammatan())) {
                        $diacriticData['Dammatan']['count']++;
                        $diacriticData['Dammatan']['locations'][] = [
                            'character_key' => (string) $chapterNumber . ':' . $verseNumber . ':' . $tokenNumber . ':' . $characterPosition,
                        ];
                    }

                    if (java_is_true($character->isKasratan())) {
                        $diacriticData['Kasratan']['count']++;
                        $diacriticData['Kasratan']['locations'][] = [
                            'character_key' => (string) $chapterNumber . ':' . $verseNumber . ':' . $tokenNumber . ':' . $characterPosition,
                        ];
                    }

                    if (java_is_true($character->isShadda())) {
                        $diacriticData['Shadda']['count']++;
                        $diacriticData['Shadda']['locations'][] = [
                            'character_key' => (string) $chapterNumber . ':' . $verseNumber . ':' . $tokenNumber . ':' . $characterPosition,
                        ];
                    }

                    if (java_is_true($character->isSukun())) {
                        $diacriticData['Sukun']['count']++;
                        $diacriticData['Sukun']['locations'][] = [
                            'character_key' => (string) $chapterNumber . ':' . $verseNumber . ':' . $tokenNumber . ':' . $characterPosition,
                        ];
                    }

                    if (java_is_true($character->isMaddah())) {
                        $diacriticData['Maddah']['count']++;
                        $diacriticData['Maddah']['locations'][] = [
                            'character_key' => (string) $chapterNumber . ':' . $verseNumber . ':' . $tokenNumber . ':' . $characterPosition,
                        ];
                    }

                    if (java_is_true($character->isHamzaAbove())) {
                        $diacriticData['HamzaAbove']['count']++;
                        $diacriticData['HamzaAbove']['locations'][] = [
                            'character_key' => (string) $chapterNumber . ':' . $verseNumber . ':' . $tokenNumber . ':' . $characterPosition,
                        ];
                    }

                    if (java_is_true($character->isHamzaBelow())) {
                        $diacriticData['HamzaBelow']['count']++;
                        $diacriticData['HamzaBelow']['locations'][] = [
                            'character_key' => (string) $chapterNumber . ':' . $verseNumber . ':' . $tokenNumber . ':' . $characterPosition,
                        ];
                    }

                    if (java_is_true($character->isHamzatWasl())) {
                        $diacriticData['HamzatWasl']['count']++;
                        $diacriticData['HamzatWasl']['locations'][] = [
                            'character_key' => (string) $chapterNumber . ':' . $verseNumber . ':' . $tokenNumber . ':' . $characterPosition,
                        ];
                    }

                    if (java_is_true($character->isAlifKhanjareeya())) {
                        $diacriticData['AlifKhanjareeya']['count']++;
                        $diacriticData['AlifKhanjareeya']['locations'][] = [
                            'character_key' => (string) $chapterNumber . ':' . $verseNumber . ':' . $tokenNumber . ':' . $characterPosition,
                        ];
                    }
                }
            }

            // Insert diacritic data into the database
            foreach ($diacriticData as $diacritic => $data) {
                DB::table($collectionName)->insert([
                    '_id' => (string) getNextSequenceValue('diacritic_frequency_id'),
                    'diacritic' => $diacritic,
                    'count' => $data['count'],
                    'locations' => $data['locations'], // Store locations as an array
                ]);
            }
        } catch (\JavaException $e) {
            echo 'Java Exception: ' . $e->getMessage();
            echo 'Stack Trace: ' . $e->getTraceAsString();
        }
    }
}
