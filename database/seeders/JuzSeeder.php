<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use MongoDB\Client as MongoClient;

class JuzSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Define the collection name
        $collectionName = 'juzs';

        createDatabaseCollection($collectionName);

        $filePath = Storage::url('quran-data\quran-data.xml');

        $xml = simplexml_load_file($filePath);

        foreach ($xml->juzs->juz as $juz) {

            DB::table($collectionName)->insert([
                '_id' => (string) getNextSequenceValue('juz_id'),
                'surah_id' => (string) $juz['sura'],
                'ayah_index' => (string) $juz['aya'],
                'ayah_key' => (string) $juz['sura'].':'.$juz['aya'],
            ]);
        }
    }
}
