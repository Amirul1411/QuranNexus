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
            $ArabicText = new \Java('org.jqurantree.arabic.ArabicText');

            $verse = $document->getVerse(13,1);

            echo $verse->getToken(4);

            // DB::table('test_verses')->insert([
            //     // '_id' => (string) getNextSequenceValue('word_id'),
            //     'surah_id' => (string) $verse->getChapterNumber(),
            //     'ayah_index' => (string) $verse->getAyahNumber(),
            //     // 'word_index' => (string) $token->getTokenNumber(),
            //     'text' => (string) $verse,
            // ]);

            $this->assertNotEmpty( $verse, "Null value is not accepted.");

        } catch (\Exception $e) {
            $this->fail("Error accessing Java API: " . $e->getMessage());
        }
    }
}

