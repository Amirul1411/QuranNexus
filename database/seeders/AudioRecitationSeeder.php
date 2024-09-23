<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class AudioRecitationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $response = Http::timeout(60)->retry(3, 1000)->get('https://api.quran.com/api/v4/quran/recitations/7');
        $data = $response->json();

        foreach ($data['audio_files'] as $audio) {
            // Access the verse_key property
            $verseKey = $audio['verse_key'];

            // Split the verse_key (e.g., "2:6") into surah_number and verse_number
            [$surahNumber, $verseNumber] = explode(':', $verseKey);

            DB::table('audio_recitations')->insert([
                '_id' => (string) getNextSequenceValue('audio_id'),
                'surah_id' => (string) $surahNumber,
                'ayah_index' => (string) $verseNumber,
                'audio_file' => (string) $audio['url'],
            ]);
        }
    }
}
