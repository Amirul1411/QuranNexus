<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CharacterFrequencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define the collection name
        $collectionName = 'character_frequency';

        createDatabaseCollection($collectionName);

        try {
            require 'http://localhost:8080/JavaBridge/java/Java.inc';

            // Get tokens from the Document class
            $document = new \Java('org.jqurantree.orthography.Document');
            $tokens = $document->getTokens();

            // Initialize character frequency and locations array
            $characterData = [
                'Alif' => ['count' => 0, 'locations' => []],
                'Ba' => ['count' => 0, 'locations' => []],
                'Ta' => ['count' => 0, 'locations' => []],
                'Tha' => ['count' => 0, 'locations' => []],
                'Jeem' => ['count' => 0, 'locations' => []],
                'HHa' => ['count' => 0, 'locations' => []],
                'Kha' => ['count' => 0, 'locations' => []],
                'Dal' => ['count' => 0, 'locations' => []],
                'Thal' => ['count' => 0, 'locations' => []],
                'Ra' => ['count' => 0, 'locations' => []],
                'Zain' => ['count' => 0, 'locations' => []],
                'Seen' => ['count' => 0, 'locations' => []],
                'Sheen' => ['count' => 0, 'locations' => []],
                'Sad' => ['count' => 0, 'locations' => []],
                'DDad' => ['count' => 0, 'locations' => []],
                'TTa' => ['count' => 0, 'locations' => []],
                'DTha' => ['count' => 0, 'locations' => []],
                'Ain' => ['count' => 0, 'locations' => []],
                'Ghain' => ['count' => 0, 'locations' => []],
                'Fa' => ['count' => 0, 'locations' => []],
                'Qaf' => ['count' => 0, 'locations' => []],
                'Kaf' => ['count' => 0, 'locations' => []],
                'Lam' => ['count' => 0, 'locations' => []],
                'Meem' => ['count' => 0, 'locations' => []],
                'Noon' => ['count' => 0, 'locations' => []],
                'Ha' => ['count' => 0, 'locations' => []],
                'Waw' => ['count' => 0, 'locations' => []],
                'Ya' => ['count' => 0, 'locations' => []],
                'Hamza' => ['count' => 0, 'locations' => []],
                'AlifMaksura' => ['count' => 0, 'locations' => []],
                'TaMarbuta' => ['count' => 0, 'locations' => []],
                'Tatweel' => ['count' => 0, 'locations' => []],
                'SmallHighSeen' => ['count' => 0, 'locations' => []],
                'SmallHighRoundedZero' => ['count' => 0, 'locations' => []],
                'SmallHighUprightRectangularZero' => ['count' => 0, 'locations' => []],
                'SmallHighMeemIsolatedForm' => ['count' => 0, 'locations' => []],
                'SmallLowSeen' => ['count' => 0, 'locations' => []],
                'SmallWaw' => ['count' => 0, 'locations' => []],
                'SmallYa' => ['count' => 0, 'locations' => []],
                'SmallHighNoon' => ['count' => 0, 'locations' => []],
                'EmptyCentreLowStop' => ['count' => 0, 'locations' => []],
                'EmptyCentreHighStop' => ['count' => 0, 'locations' => []],
                'RoundedHighStopWithFilledCentre' => ['count' => 0, 'locations' => []],
                'SmallLowMeem' => ['count' => 0, 'locations' => []],
            ];

            // Iterate over tokens and record character frequencies and locations
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
                    $characterType = (string) $character->getType();
                    $characterPosition++;

                    if ($characterType == 'Alif') {
                        $characterData['Alif']['count']++;
                        $characterData['Alif']['locations'][] = [
                            'character_key' => (string) $chapterNumber . ':' . $verseNumber . ':' . $tokenNumber . ':' . $characterPosition,
                        ];
                    }

                    if ($characterType == 'Ba') {
                        $characterData['Ba']['count']++;
                        $characterData['Ba']['locations'][] = [
                            'character_key' => (string) $chapterNumber . ':' . $verseNumber . ':' . $tokenNumber . ':' . $characterPosition,
                        ];
                    }

                    if ($characterType == 'Ta') {
                        $characterData['Ta']['count']++;
                        $characterData['Ta']['locations'][] = [
                            'character_key' => (string) $chapterNumber . ':' . $verseNumber . ':' . $tokenNumber . ':' . $characterPosition,
                        ];
                    }

                    if ($characterType == 'Tha') {
                        $characterData['Tha']['count']++;
                        $characterData['Tha']['locations'][] = [
                            'character_key' => (string) $chapterNumber . ':' . $verseNumber . ':' . $tokenNumber . ':' . $characterPosition,
                        ];
                    }

                    if ($characterType == 'Jeem') {
                        $characterData['Jeem']['count']++;
                        $characterData['Jeem']['locations'][] = [
                            'character_key' => (string) $chapterNumber . ':' . $verseNumber . ':' . $tokenNumber . ':' . $characterPosition,
                        ];
                    }

                    if ($characterType == 'HHa') {
                        $characterData['HHa']['count']++;
                        $characterData['HHa']['locations'][] = [
                            'character_key' => (string) $chapterNumber . ':' . $verseNumber . ':' . $tokenNumber . ':' . $characterPosition,
                        ];
                    }

                    if ($characterType == 'Kha') {
                        $characterData['Kha']['count']++;
                        $characterData['Kha']['locations'][] = [
                            'character_key' => (string) $chapterNumber . ':' . $verseNumber . ':' . $tokenNumber . ':' . $characterPosition,
                        ];
                    }

                    if ($characterType == 'Dal') {
                        $characterData['Dal']['count']++;
                        $characterData['Dal']['locations'][] = [
                            'character_key' => (string) $chapterNumber . ':' . $verseNumber . ':' . $tokenNumber . ':' . $characterPosition,
                        ];
                    }

                    if ($characterType == 'Thal') {
                        $characterData['Thal']['count']++;
                        $characterData['Thal']['locations'][] = [
                            'character_key' => (string) $chapterNumber . ':' . $verseNumber . ':' . $tokenNumber . ':' . $characterPosition,
                        ];
                    }

                    if ($characterType == 'Ra') {
                        $characterData['Ra']['count']++;
                        $characterData['Ra']['locations'][] = [
                            'character_key' => (string) $chapterNumber . ':' . $verseNumber . ':' . $tokenNumber . ':' . $characterPosition,
                        ];
                    }

                    if ($characterType == 'Zain') {
                        $characterData['Zain']['count']++;
                        $characterData['Zain']['locations'][] = [
                            'character_key' => (string) $chapterNumber . ':' . $verseNumber . ':' . $tokenNumber . ':' . $characterPosition,
                        ];
                    }

                    if ($characterType == 'Seen') {
                        $characterData['Seen']['count']++;
                        $characterData['Seen']['locations'][] = [
                            'character_key' => (string) $chapterNumber . ':' . $verseNumber . ':' . $tokenNumber . ':' . $characterPosition,
                        ];
                    }

                    if ($characterType == 'Sheen') {
                        $characterData['Sheen']['count']++;
                        $characterData['Sheen']['locations'][] = [
                            'character_key' => (string) $chapterNumber . ':' . $verseNumber . ':' . $tokenNumber . ':' . $characterPosition,
                        ];
                    }

                    if ($characterType == 'Sad') {
                        $characterData['Sad']['count']++;
                        $characterData['Sad']['locations'][] = [
                            'character_key' => (string) $chapterNumber . ':' . $verseNumber . ':' . $tokenNumber . ':' . $characterPosition,
                        ];
                    }

                    if ($characterType == 'DDad') {
                        $characterData['DDad']['count']++;
                        $characterData['DDad']['locations'][] = [
                            'character_key' => (string) $chapterNumber . ':' . $verseNumber . ':' . $tokenNumber . ':' . $characterPosition,
                        ];
                    }

                    if ($characterType == 'TTa') {
                        $characterData['TTa']['count']++;
                        $characterData['TTa']['locations'][] = [
                            'character_key' => (string) $chapterNumber . ':' . $verseNumber . ':' . $tokenNumber . ':' . $characterPosition,
                        ];
                    }

                    if ($characterType == 'DTha') {
                        $characterData['DTha']['count']++;
                        $characterData['DTha']['locations'][] = [
                            'character_key' => (string) $chapterNumber . ':' . $verseNumber . ':' . $tokenNumber . ':' . $characterPosition,
                        ];
                    }

                    if ($characterType == 'Ain') {
                        $characterData['Ain']['count']++;
                        $characterData['Ain']['locations'][] = [
                            'character_key' => (string) $chapterNumber . ':' . $verseNumber . ':' . $tokenNumber . ':' . $characterPosition,
                        ];
                    }

                    if ($characterType == 'Ghain') {
                        $characterData['Ghain']['count']++;
                        $characterData['Ghain']['locations'][] = [
                            'character_key' => (string) $chapterNumber . ':' . $verseNumber . ':' . $tokenNumber . ':' . $characterPosition,
                        ];
                    }

                    if ($characterType == 'Fa') {
                        $characterData['Fa']['count']++;
                        $characterData['Fa']['locations'][] = [
                            'character_key' => (string) $chapterNumber . ':' . $verseNumber . ':' . $tokenNumber . ':' . $characterPosition,
                        ];
                    }

                    if ($characterType == 'Qaf') {
                        $characterData['Qaf']['count']++;
                        $characterData['Qaf']['locations'][] = [
                            'character_key' => (string) $chapterNumber . ':' . $verseNumber . ':' . $tokenNumber . ':' . $characterPosition,
                        ];
                    }

                    if ($characterType == 'Kaf') {
                        $characterData['Kaf']['count']++;
                        $characterData['Kaf']['locations'][] = [
                            'character_key' => (string) $chapterNumber . ':' . $verseNumber . ':' . $tokenNumber . ':' . $characterPosition,
                        ];
                    }

                    if ($characterType == 'Lam') {
                        $characterData['Lam']['count']++;
                        $characterData['Lam']['locations'][] = [
                            'character_key' => (string) $chapterNumber . ':' . $verseNumber . ':' . $tokenNumber . ':' . $characterPosition,
                        ];
                    }

                    if ($characterType == 'Meem') {
                        $characterData['Meem']['count']++;
                        $characterData['Meem']['locations'][] = [
                            'character_key' => (string) $chapterNumber . ':' . $verseNumber . ':' . $tokenNumber . ':' . $characterPosition,
                        ];
                    }

                    if ($characterType == 'Noon') {
                        $characterData['Noon']['count']++;
                        $characterData['Noon']['locations'][] = [
                            'character_key' => (string) $chapterNumber . ':' . $verseNumber . ':' . $tokenNumber . ':' . $characterPosition,
                        ];
                    }

                    if ($characterType == 'Ha') {
                        $characterData['Ha']['count']++;
                        $characterData['Ha']['locations'][] = [
                            'character_key' => (string) $chapterNumber . ':' . $verseNumber . ':' . $tokenNumber . ':' . $characterPosition,
                        ];
                    }

                    if ($characterType == 'Waw') {
                        $characterData['Waw']['count']++;
                        $characterData['Waw']['locations'][] = [
                            'character_key' => (string) $chapterNumber . ':' . $verseNumber . ':' . $tokenNumber . ':' . $characterPosition,
                        ];
                    }

                    if ($characterType == 'Ya') {
                        $characterData['Ya']['count']++;
                        $characterData['Ya']['locations'][] = [
                            'character_key' => (string) $chapterNumber . ':' . $verseNumber . ':' . $tokenNumber . ':' . $characterPosition,
                        ];
                    }

                    if ($characterType == 'Hamza') {
                        $characterData['Hamza']['count']++;
                        $characterData['Hamza']['locations'][] = [
                            'character_key' => (string) $chapterNumber . ':' . $verseNumber . ':' . $tokenNumber . ':' . $characterPosition,
                        ];
                    }

                    if ($characterType == 'AlifMaksura') {
                        $characterData['AlifMaksura']['count']++;
                        $characterData['AlifMaksura']['locations'][] = [
                            'character_key' => (string) $chapterNumber . ':' . $verseNumber . ':' . $tokenNumber . ':' . $characterPosition,
                        ];
                    }

                    if ($characterType == 'TaMarbuta') {
                        $characterData['TaMarbuta']['count']++;
                        $characterData['TaMarbuta']['locations'][] = [
                            'character_key' => (string) $chapterNumber . ':' . $verseNumber . ':' . $tokenNumber . ':' . $characterPosition,
                        ];
                    }

                    if ($characterType == 'Tatweel') {
                        $characterData['Tatweel']['count']++;
                        $characterData['Tatweel']['locations'][] = [
                            'character_key' => (string) $chapterNumber . ':' . $verseNumber . ':' . $tokenNumber . ':' . $characterPosition,
                        ];
                    }

                    if ($characterType == 'SmallHighSeen') {
                        $characterData['SmallHighSeen']['count']++;
                        $characterData['SmallHighSeen']['locations'][] = [
                            'character_key' => (string) $chapterNumber . ':' . $verseNumber . ':' . $tokenNumber . ':' . $characterPosition,
                        ];
                    }

                    if ($characterType == 'SmallHighRoundedZero') {
                        $characterData['SmallHighRoundedZero']['count']++;
                        $characterData['SmallHighRoundedZero']['locations'][] = [
                            'character_key' => (string) $chapterNumber . ':' . $verseNumber . ':' . $tokenNumber . ':' . $characterPosition,
                        ];
                    }

                    if ($characterType == 'SmallHighUprightRectangularZero') {
                        $characterData['SmallHighUprightRectangularZero']['count']++;
                        $characterData['SmallHighUprightRectangularZero']['locations'][] = [
                            'character_key' => (string) $chapterNumber . ':' . $verseNumber . ':' . $tokenNumber . ':' . $characterPosition,
                        ];
                    }

                    if ($characterType == 'SmallHighMeemIsolatedForm') {
                        $characterData['SmallHighMeemIsolatedForm']['count']++;
                        $characterData['SmallHighMeemIsolatedForm']['locations'][] = [
                            'character_key' => (string) $chapterNumber . ':' . $verseNumber . ':' . $tokenNumber . ':' . $characterPosition,
                        ];
                    }

                    if ($characterType == 'SmallLowSeen') {
                        $characterData['SmallLowSeen']['count']++;
                        $characterData['SmallLowSeen']['locations'][] = [
                            'character_key' => (string) $chapterNumber . ':' . $verseNumber . ':' . $tokenNumber . ':' . $characterPosition,
                        ];
                    }

                    if ($characterType == 'SmallWaw') {
                        $characterData['SmallWaw']['count']++;
                        $characterData['SmallWaw']['locations'][] = [
                            'character_key' => (string) $chapterNumber . ':' . $verseNumber . ':' . $tokenNumber . ':' . $characterPosition,
                        ];
                    }

                    if ($characterType == 'SmallYa') {
                        $characterData['SmallYa']['count']++;
                        $characterData['SmallYa']['locations'][] = [
                            'character_key' => (string) $chapterNumber . ':' . $verseNumber . ':' . $tokenNumber . ':' . $characterPosition,
                        ];
                    }

                    if ($characterType == 'SmallHighNoon') {
                        $characterData['SmallHighNoon']['count']++;
                        $characterData['SmallHighNoon']['locations'][] = [
                            'character_key' => (string) $chapterNumber . ':' . $verseNumber . ':' . $tokenNumber . ':' . $characterPosition,
                        ];
                    }

                    if ($characterType == 'EmptyCentreLowStop') {
                        $characterData['EmptyCentreLowStop']['count']++;
                        $characterData['EmptyCentreLowStop']['locations'][] = [
                            'character_key' => (string) $chapterNumber . ':' . $verseNumber . ':' . $tokenNumber . ':' . $characterPosition,
                        ];
                    }

                    if ($characterType == 'EmptyCentreHighStop') {
                        $characterData['EmptyCentreHighStop']['count']++;
                        $characterData['EmptyCentreHighStop']['locations'][] = [
                            'character_key' => (string) $chapterNumber . ':' . $verseNumber . ':' . $tokenNumber . ':' . $characterPosition,
                        ];
                    }

                    if ($characterType == 'RoundedHighStopWithFilledCentre') {
                        $characterData['RoundedHighStopWithFilledCentre']['count']++;
                        $characterData['RoundedHighStopWithFilledCentre']['locations'][] = [
                            'character_key' => (string) $chapterNumber . ':' . $verseNumber . ':' . $tokenNumber . ':' . $characterPosition,
                        ];
                    }

                    if ($characterType == 'SmallLowMeem') {
                        $characterData['SmallLowMeem']['count']++;
                        $characterData['SmallLowMeem']['locations'][] = [
                            'character_key' => (string) $chapterNumber . ':' . $verseNumber . ':' . $tokenNumber . ':' . $characterPosition,
                        ];
                    }
                }
            }

            // Insert character data into the database
            foreach ($characterData as $character => $data) {
                DB::table($collectionName)->insert([
                    '_id' => (string) getNextSequenceValue('character_frequency_id'),
                    'character' => $character,
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
