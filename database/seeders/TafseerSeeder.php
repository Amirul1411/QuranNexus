<?php

namespace Database\Seeders;

use App\Models\Ayah;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class TafseerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $allAyahs = Ayah::all();

        foreach ($allAyahs as $ayah) {
            $response = Http::timeout(60)
                ->retry(3, 1000)
                ->get('https://api.quran.com/api/v4/quran/tafsirs/160?verse_key='.$ayah->surah_id.':'.$ayah->ayah_index);

            // Extract JSON data from the response
            $data = $response->json();
            $tafseers = $data['tafsirs'];

            foreach($tafseers as $tafseer){
                if($tafseer['resource_id'] === 169){
                    $html = $tafseer['text'];
                    break;
                }
            }


            DB::table('tafseer')->insert([
                '_id' => (string) getNextSequenceValue('tafseer_id'),
                'surah_id' => (string) $ayah->surah_id,
                'ayah_index' => (string) $ayah->ayah_index,
                'html' => (string) $html,
            ]);
        }
    }
}
