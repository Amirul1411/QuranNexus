<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Sushi\Sushi;

class DiacriticFrequency extends Model
{
    use Sushi;

    public function getRows(): array
    {
        try {
            require 'http://13.229.243.29:8080/JavaBridge/java/Java.inc';

            // Get tokens from the Document class
            $document = new \Java('org.jqurantree.orthography.Document');
            $tokens = $document->getTokens();

            $diacriticFrequency = [
                'Fatha' => 0,
                'Damma' => 0,
                'Kasra' => 0,
                'Fathatan' => 0,
                'Dammatan' => 0,
                'Kasratan' => 0,
                'Shadda' => 0,
                'Sukun' => 0,
                'Maddah' => 0,
                'HamzaAbove' => 0,
                'HamzaBelow' => 0,
                'HamzatWasl' => 0,
                'AlifKhanjareeya' => 0,
            ];

            // Iterate over tokens and count character frequencies
            $tokenIterator = $tokens->iterator();
            while (java_is_true($tokenIterator->hasNext())) {
                $token = $tokenIterator->next();

                $characterIterator = $token->iterator();
                while (java_is_true($characterIterator->hasNext())) {
                    $character = $characterIterator->next();

                    if (java_is_true($character->isFatha())) {
                        $diacriticFrequency['Fatha']++;
                    }

                    if (java_is_true($character->isDamma())) {
                        $diacriticFrequency['Damma']++;
                    }

                    if (java_is_true($character->isKasra())) {
                        $diacriticFrequency['Kasra']++;
                    }

                    if (java_is_true($character->isFathatan())) {
                        $diacriticFrequency['Fathatan']++;
                    }

                    if (java_is_true($character->isDammatan())) {
                        $diacriticFrequency['Dammatan']++;
                    }

                    if (java_is_true($character->isKasratan())) {
                        $diacriticFrequency['Kasratan']++;
                    }

                    if (java_is_true($character->isShadda())) {
                        $diacriticFrequency['Shadda']++;
                    }

                    if (java_is_true($character->isSukun())) {
                        $diacriticFrequency['Sukun']++;
                    }

                    if (java_is_true($character->isMaddah())) {
                        $diacriticFrequency['Maddah']++;
                    }

                    if (java_is_true($character->isHamzaAbove())) {
                        $diacriticFrequency['HamzaAbove']++;
                    }

                    if (java_is_true($character->isHamzaBelow())) {
                        $diacriticFrequency['HamzaBelow']++;
                    }

                    if (java_is_true($character->isHamzatWasl())) {
                        $diacriticFrequency['HamzatWasl']++;
                    }

                    if (java_is_true($character->isAlifKhanjareeya())) {
                        $diacriticFrequency['AlifKhanjareeya']++;
                    }
                }
            }

            // Sort the character frequency array by count in descending order
            // arsort($diacriticFrequency);

            // Convert to the required rows format
            $rows = [];
            foreach ($diacriticFrequency as $diacritic => $count) {
                $rows[] = [
                    'diacritic' => (string) $diacritic,
                    'count' => $count,
                ];
            }

            return $rows;
        } catch (\JavaException $e) {
            echo 'Java Exception: ' . $e->getMessage();
            echo 'Stack Trace: ' . $e->getTraceAsString();
            return [];
        }
    }
}
