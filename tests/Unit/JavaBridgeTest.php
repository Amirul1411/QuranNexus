<?php

namespace Tests\Feature;

use App\Models\Ayah;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class JavaBridgeTest extends TestCase
{
    public function testJavaBridge()
    {

        // Include the JavaBridge library
        require("http://localhost:8080/JavaBridge/java/Java.inc");

        // $ayah = Ayah::find(9);
        // $text = $ayah->text;

        try {
            // Create an instance of the Document class
            $document = new \Java('org.jqurantree.orthography.Document');
            // $arabicCharacter = new \Java('org.jqurantree.arabic.ArabicCharacter');

            $token = $document->getToken(37,130,3);
            // $tokenText = $token;
            $nextToken = $document->getToken(37,130,4);
            $tokenText = $token . " " . $nextToken;

            echo $token->getCharacter(0),

            // if((string) $token->getChapterNumber() === "37" && (string) $token->getVerseNumber() === "130" && (string) $token->getTokenNumber() === "3"){
                // $nextToken = $document->getToken(37,130,4);
                // $tokenText = $token . " " . $nextToken;
            // }else{
            //     $tokenText = $token;
            // }

            // $tokenLength = java_cast($token->getLength(), 'int');

            // for ($i=0; $i < $tokenLength; $i++) {
            //     // Add the character type to the array
            //     $characters[] = java_cast($token->getCharacter($i)->toUnicode(), 'string');
            // }

            // if((string) $token->getChapterNumber() === "37" && (string) $token->getVerseNumber() === "130" && (string) $token->getTokenNumber() === "3"){

                // $nextToken = $document->getToken(37,130,4);
                // $nextTokenLength = java_cast($nextToken->getLength(), 'int');

                // for ($i=0; $i < $nextTokenLength; $i++) {
                //     // Add the character type to the array
                //     $characters[] = java_cast($nextToken->getCharacter($i)->toUnicode(), 'string');
                // }
            // }

            // echo $tokenText;
            // $tokenLength = java_cast($token->getLength(), 'int');
            // $characters = [];
            // $tokenText = $token . $nextToken;

            // for ($i=0; $i < $tokenLength; $i++) {
            //     // Add the character type to the array
            //     $characters[] = java_cast($token->getCharacter($i)->toUnicode(), 'string');
            // }

            // echo "Character Types: " . implode(", ", $characters);

            // DB::table('test_words')->insert([
            //     // '_id' => (string) getNextSequenceValue('word_id'),
            //     // 'surah_id' => (string) $verse->getChapterNumber(),
            //     // 'ayah_index' => (string) $verse->getAyahNumber(),
            //     // 'word_index' => (string) $token->getTokenNumber(),
            //     'token' => (string) $tokenText,
            //     'characters' => $characters,
            // ]);

            $this->assertNotEmpty( $token, "Null value is not accepted.");

        } catch (\Exception $e) {
            $this->fail("Error accessing Java API: " . $e->getMessage());
        }
    }
}

