<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Sushi\Sushi;

class CharacterFrequency extends Model
{
    use Sushi;

    public function getRows(): array
    {
        try {
            require 'http://localhost:8080/JavaBridge/java/Java.inc';

            // Get tokens from the Document class
            $document = new \Java('org.jqurantree.orthography.Document');
            $tokens = $document->getTokens();

            // Use a PHP array to store character frequencies
            $characterFrequency = [];

            // Iterate over tokens and count character frequencies
            $tokenIterator = $tokens->iterator();
            while (java_is_true($tokenIterator->hasNext())) {
                $token = $tokenIterator->next();

                $characterIterator = $token->iterator();
                while (java_is_true($characterIterator->hasNext())) {
                    $character = $characterIterator->next();
                    $characterType = (string) $character->getType();

                    // Update frequency in the array
                    if (!isset($characterFrequency[$characterType])) {
                        $characterFrequency[$characterType] = 0;
                    }
                    $characterFrequency[$characterType]++;
                }
            }

            // Sort the character frequency array by count in descending order
            // arsort($characterFrequency);

            // Convert to the required rows format
            $rows = [];
            foreach ($characterFrequency as $character => $count) {
                $rows[] = [
                    'character' => $character,
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
