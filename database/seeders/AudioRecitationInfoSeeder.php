<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class AudioRecitationInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $recitationId = [7, 2];
        $response = Http::timeout(60)->retry(3, 1000)->get('https://api.quran.com/api/v4/resources/recitations');
        $data = $response->json();

        foreach($recitationId as $id){
            foreach ($data['recitations'] as $recitation) {

                if($recitation['id'] == $id){
                    DB::table('audio_recitation_info')->insert([
                        '_id' => (string) getNextSequenceValue('audio_info_id'),
                        'reciter_name' => (string) $recitation['reciter_name'],
                        'style' => (string) $recitation['style'],
                        'translated_name' => $recitation['translated_name'],
                    ]);
                    break;
                }
            }
        }
    }
}
