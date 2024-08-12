<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed database from jQuranTree

        // Include the JavaBridge library
        require("http://localhost:8080/JavaBridge/java/Java.inc");

        try {
            // Create an instance of the Document class
            $document = new \Java('org.jqurantree.orthography.Document');

            // Call the getChapters method
            $tokensIterable = $document->getTokens();

            if ($tokensIterable instanceof \Java) {

                $iterator = $tokensIterable->iterator(); // Get an iterator

                while (java_is_true($iterator->hasNext())) {

                    $token = $iterator->next();

                    DB::table('words')->insert([
                        '_id' => (string) getNextSequenceValue('word_id'),
                        'surah_id' => (string) $token->getChapterNumber(),
                        'ayah_index' => (string) $token->getVerseNumber(),
                        'word_index' => (string) $token->getTokenNumber(),
                        'text' => (string) $token,
                    ]);

                }


            } else {
                echo "The result from Java API is not an Iterable.";
            }
        } catch (\Exception $e) {
            echo "Error accessing Java API: " . $e->getMessage();
        }
    }
}
