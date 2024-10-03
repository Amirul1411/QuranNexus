<?php

namespace Database\Seeders;

use App\Models\Surah;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class SurahInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $allSurahs = Surah::all();

        foreach ($allSurahs as $surah) {
            $response = Http::timeout(60)
                ->retry(3, 1000)
                ->get('https://api.quran.com/api/v4/chapters/' . $surah->id . '/info');

            // Extract JSON data from the response
            $data = $response->json();
            $chapterInfo = $data['chapter_info'];
            $html = $chapterInfo['text'];

            DB::table('surah_info')->insert([
                '_id' => (string) getNextSequenceValue('surah_info_id'),
                'html' => (string) $html,
            ]);
        }
    }
}
