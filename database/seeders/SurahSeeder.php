<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SurahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $filePath = resource_path('data\quran-data.xml');

        $xml = simplexml_load_file($filePath);

        foreach ($xml->suras->sura as $sura) {

            DB::table('surahs')->insert([
                '_id' => (string) getNextSequenceValue('surah_id'),
                'name' => (string) $sura['name'],
                'tname' => (string) $sura['tname'],
                'ename' => (string) $sura['ename'],
                'ayas' => (int) $sura['ayas'],
            ]);
        }
    }
}
