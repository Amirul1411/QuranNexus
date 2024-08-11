<?php

namespace Tests\Feature;

use Tests\TestCase;

class JavaBridgeTest extends TestCase
{
    public function testJavaBridge()
    {
        // Include the JavaBridge library
        require_once("http://localhost:8080/JavaBridge/java/Java.inc");

        try {
            // Create an instance of the Document class
            $document = new \Java('org.jqurantree.orthography.Document');

            // Call the getChapters method
            $chaptersIterable = $document->getChapters();

            if ($chaptersIterable instanceof \Java) {
                $iterator = $chaptersIterable->iterator(); // Get an iterator

                // Limit iterations for testing
                $count = 0;
                while ($iterator->hasNext()) { // Limiting to first 10 chapters for testing
                    $chapter = $iterator->next();

                    // Call getName() on each chapter
                    $name = $chapter->getName();

                    // Convert Java String to PHP string if necessary
                    if ($name instanceof \Java) {
                        $name = $name->toString(); // Convert Java String to PHP string
                    }

                    // Output the chapter name
                    echo "Chapter Count: " . $count + 1;
                    echo "Chapter Name: " . $name . "\n";
                    $count++;
                }

                // Assert that we processed some chapters
                $this->assertGreaterThan(0, $count, "At least one chapter should be processed");

            } else {
                $this->fail("The result from Java API is not an Iterable.");
            }
        } catch (\Exception $e) {
            $this->fail("Error accessing Java API: " . $e->getMessage());
        }
    }
}

