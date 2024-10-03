<?php

namespace Database\Seeders;

use App\Models\AudioRecitation;
use App\Models\Ayah;
use App\Models\Inquiry;
use App\Models\Juz;
use App\Models\Page;
use App\Models\Surah;
use App\Models\SurahInfo;
use App\Models\Tafseer;
use App\Models\Translation;
use App\Models\User;
use App\Models\Word;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CounterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Delete all existing documents in the 'counters' collection
        DB::collection('counters')->delete();

        // Insert initial documents for each collection counter
        DB::collection('counters')->insert([
            ['_id' => 'user_id', 'sequence_value' => User::count()],
            ['_id' => 'inquiry_id', 'sequence_value' => Inquiry::count()],
            ['_id' => 'surah_id', 'sequence_value' => Surah::count()],
            ['_id' => 'surah_info_id', 'sequence_value' => SurahInfo::count()],
            ['_id' => 'ayah_id', 'sequence_value' => Ayah::count()],
            ['_id' => 'word_id', 'sequence_value' => Word::count()],
            ['_id' => 'tafseer_id', 'sequence_value' => Tafseer::count()],
            ['_id' => 'page_id', 'sequence_value' => Page::count()],
            ['_id' => 'juz_id', 'sequence_value' => Juz::count()],
            ['_id' => 'translation_id', 'sequence_value' => Translation::count()],
            ['_id' => 'audio_id', 'sequence_value' => AudioRecitation::count()],
            // Add more collections as needed
        ]);
    }
}
