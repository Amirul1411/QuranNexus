<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JuzSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = resource_path('data\quran-data.xml');

        $xml = simplexml_load_file($filePath);

        foreach ($xml->juzs->juz as $juz) {

            DB::table('juzs')->insert([
                '_id' => (string) getNextSequenceValue('juz_id'),
                'surah_id' => (string) $juz['sura'],
                'ayah_index' => (string) $juz['aya'],
                'ayah_key' => (string) $juz['sura'].':'.$juz['aya'],
            ]);
        }
    }
}
