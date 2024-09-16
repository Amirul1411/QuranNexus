<?php

namespace Tests\Feature;

use App\Models\Ayah;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class generalTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
{
    $allAyah = Ayah::all();

    foreach ($allAyah as $ayah) {

        // Split the text property into words
        $splittedAyah = explode(" ", $ayah->text);

        // Loop through the words and insert each one into the test_words table
        foreach ($splittedAyah as $index => $word) {

            $index = $index+1;

            DB::table('test_words')->insert([
                // '_id' => (string) getNextSequenceValue('word_id'),
                'surah_id' => (string) $ayah->surah_id,
                'ayah_index' => (string) $ayah->ayah_index,
                'word_index' => (string) $index,
                'text' => (string) $word,
            ]);
        }
    }

    $this->assertNotEmpty($allAyah);
}

}
