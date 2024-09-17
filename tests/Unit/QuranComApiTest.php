<?php

namespace Tests\Feature;

use App\Models\Word;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Http;

class QuranComApiTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        for($i = 1; $i <= 2; $i++){
            // Make an external API request using the Http facade
            $response = Http::get('https://api.quran.com/api/v4/verses/by_page/' . $i . '?words=true');

            // Output the response content as JSON
            // $jsonContent = $response->json();
            // echo json_encode($jsonContent, JSON_PRETTY_PRINT);

            // Extract JSON data from the response
            $data = $response->json();

            // Loop through verses
            foreach ($data['verses'] as $verse) {
                // Access the verse_key property
                $verseKey = $verse['verse_key'];

                // Split the verse_key (e.g., "2:6") into surah_number and verse_number
                list($surahNumber, $verseNumber) = explode(':', $verseKey);

                echo "Surah Number: " . $surahNumber . PHP_EOL;
                echo "Verse Number: " . $verseNumber . PHP_EOL;

                // Loop through words within each verse
                foreach ($verse['words'] as $word) {
                    // Access the position property
                    $wordPosition = $word['position'];
                    echo "Word Position: " . $wordPosition . PHP_EOL;

                    $wordModel = Word::where('surah_id', (string) $surahNumber)
                    ->where('ayah_index', (string) $verseNumber)
                    ->where('word_index', (string) $wordPosition)
                    ->first();

                    echo $wordModel->text;

                }
            }
        }

        // Ensure the response status is 200
        $this->assertEquals(200, $response->status());
    }
}
