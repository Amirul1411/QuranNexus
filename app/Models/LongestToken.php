<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Sushi\Sushi;

class LongestToken extends Model
{
    use Sushi;

    public function getRows(): array
    {
        try {
            require 'http://localhost:8080/JavaBridge/java/Java.inc';

            // Get tokens from the Document class
            $document = new \Java('org.jqurantree.orthography.Document');
            $tokens = $document->getTokens();

            // Array to store tokens of target letter count
            // Longest token in the whole quran has a letter count of 11
            $targetLetterCount = [8, 9, 10, 11];
            $selectedTokens = [];

            // Iterate over tokens and find those matching target lengths
            $tokenIterator = $tokens->iterator();
            while (java_is_true($tokenIterator->hasNext())) {
                $token = $tokenIterator->next();
                $tokenLength = java_cast($token->getLetterCount(), 'int');

                if (in_array($tokenLength, $targetLetterCount)) {
                    $selectedTokens[] = [
                        'chapter' =>  (string) $token->getChapter()->getName()->toUnicode(),
                        'verse' => $token->getVerseNumber(),
                        'token_number' => $token->getTokenNumber(),
                        'token' => $token->toUnicode(),
                        'length' => $tokenLength,
                    ];
                }
            }

            // Sort the tokens by the 'length' key in descending order
            usort($selectedTokens, function ($a, $b) {
                return $b['length'] <=> $a['length']; // Descending order
            });

            // Convert results into the required rows format
            return $selectedTokens;

        } catch (\JavaException $e) {
            echo 'Java Exception: ' . $e->getMessage();
            echo 'Stack Trace: ' . $e->getTraceAsString();
            return [];
        }
    }
}
