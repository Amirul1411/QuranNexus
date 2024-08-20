<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class JavaBridgeTest extends TestCase
{
    public function testJavaBridge()
    {

        // Set internal encoding to UTF-8
        mb_internal_encoding("UTF-8");

        // Include the JavaBridge library
        require("http://localhost:8080/JavaBridge/java/Java.inc");

        try {
            // Create an instance of the Document class
            $document = new \Java('org.jqurantree.orthography.Document');
            $ArabicText = new \Java('org.jqurantree.arabic.ArabicText');

            $verse = $document->getVerse(2,2);

            DB::table('test_verses')->insert([
                // '_id' => (string) getNextSequenceValue('word_id'),
                'surah_id' => (string) $verse->getChapterNumber(),
                'ayah_index' => (string) $verse->getVerseNumber(),
                // 'word_index' => (string) $token->getTokenNumber(),
                'text' => (string) $ArabicText->fromBuckwalter($verse),
            ]);

            // $tokensIterable = $verse->getTokens();

            // if ($tokensIterable instanceof \Java) {

            //     $iterator = $tokensIterable->iterator(); // Get an iterator

            //     while (java_is_true($iterator->hasNext())) {

            //         $token = $iterator->next();

            //         DB::table('test_words')->insert([
            //             // '_id' => (string) getNextSequenceValue('word_id'),
            //             'surah_id' => (string) $token->getChapterNumber(),
            //             'ayah_index' => (string) $token->getVerseNumber(),
            //             'word_index' => (string) $token->getTokenNumber(),
            //             'text' => (string) $token->toSimpleEncoding(),
            //         ]);

            //     }


            // } else {
            //     echo "The result from Java API is not an Iterable.";
            // }

            $this->assertNotEmpty( $verse, "Null value is not accepted.");

        } catch (\Exception $e) {
            $this->fail("Error accessing Java API: " . $e->getMessage());
        }
    }
}

