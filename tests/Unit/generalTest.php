<?php

namespace Tests\Feature;

use App\Models\Ayah;
use App\Models\Word;
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

    $word = Word::where('surah_id', '1')
                    ->where('ayah_index', '1')
                    ->where('word_index', '1')
                    ->first();

    echo $word->text;

    $this->assertNotEmpty($word);
}

}
