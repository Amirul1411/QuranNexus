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
        require_once("http://13.229.243.29:8080/JavaBridge/java/Java.inc");

        // $ayah = Ayah::find(9);
        // $text = $ayah->text;

        try {
            // Create an instance of the Document class
            // $document = new \Java('org.jqurantree.orthography.Document');
            $diacriticType = new \Java('org.jqurantree.arabic.DiacriticType');

            dd("test");
            // $arabicCharacter = new \Java('org.jqurantree.arabic.ArabicCharacter');

            // $token = $document->getToken(2,25,26);
            // $tokenText = $token;
            // $nextToken = $document->getToken(37,130,4);
            // $tokenText = $token . " " . $nextToken;
            $diacriticVal[] = $diacriticType->values;
            $diacriticValStr = [];

            foreach($diacriticVal as $val){
                 $diacriticValStr = [];
            }

            $this->assertNotEmpty( $diacriticType, "Null value is not accepted.");

        } catch (\Exception $e) {
            $this->fail("Error accessing Java API: " . $e->getMessage());
        }
    }
}

