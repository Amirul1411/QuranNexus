<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Sushi\Sushi;
use Illuminate\Support\Arr;

class ChaptersInitials extends Model
{
    use Sushi;

    public function getRows(): array
    {
        try {

            require 'http://13.229.243.29:8080/JavaBridge/java/Java.inc';

            $document = new \Java('org.jqurantree.orthography.Document');
            $tokensIterable = $document->getTokens(); // Replace this with your actual source for tokens
            $iterator = $tokensIterable->iterator();
            $analysisTable = [];

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
                    $chapter =  (string) $token->getChapter()->getName()->toUnicode();
                    $verseLocation = $token->getVerse()->getLocation();
                    $initials = $token->removeDiacritics()->toUnicode();
                    $analysisTable[] = [
                        'chapter' => $chapter,
                        'verse' => $verseLocation,
                        'initials' => $initials,
                    ];
                }
            }

            return $analysisTable;

        } catch (\JavaException $e) {
            echo 'Java Exception: ' . $e->getMessage();
            echo 'Stack Trace: ' . $e->getTraceAsString();
        }
    }

    public function getVerseAttribute(): ?string
    {
        return $this->attributes['verse'] ?? null;
    }
}
