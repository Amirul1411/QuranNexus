<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Sushi\Sushi;

class VerseCount extends Model
{
    use Sushi;

    public function getRows(): array
    {
        try {

            require 'http://13.229.243.29:8080/JavaBridge/java/Java.inc';

            $document = new \Java('org.jqurantree.orthography.Document');
            $chaptersIterable = $document->getChapters(); // Replace this with your actual source for tokens
            $iterator = $chaptersIterable->iterator();
            $analysisTable = [];

            while (java_is_true($iterator->hasNext())) {

                $chapter = $iterator->next();
                $verseCount = $chapter->getVerseCount();
                $analysisTable[] = [
                        'chapter' =>  (string) $chapter->getName()->toUnicode(),
                        'verseCount' => $verseCount,
                ];

            }

            return $analysisTable;

        } catch (\JavaException $e) {
            echo 'Java Exception: ' . $e->getMessage();
            echo 'Stack Trace: ' . $e->getTraceAsString();
        }
    }

}
