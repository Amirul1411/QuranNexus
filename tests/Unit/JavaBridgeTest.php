<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class JavaBridgeTest extends TestCase
{
    public function testJavaBridge()
    {
        // Include the JavaBridge library
        require("http://localhost:8080/JavaBridge/java/Java.inc");

        try {
            // Create an instance of the Document class
            $document = new \Java('org.jqurantree.orthography.Document');

            echo $document->getTokenCount();

            $this->assertNotEmpty($document, "Document should not be null.");
            
        } catch (\Exception $e) {
            $this->fail("Error accessing Java API: " . $e->getMessage());
        }
    }
}

