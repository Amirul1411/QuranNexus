<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use MongoDB\Client as MongoClient;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Define the collection name
        $collectionName = 'pages';

        createDatabaseCollection($collectionName);

        $filePath = resource_path('data\quran-data.xml');

        $xml = simplexml_load_file($filePath);

        foreach ($xml->pages->page as $page) {

            DB::table($collectionName)->insert([
                '_id' => (string) getNextSequenceValue('page_id'),
                'surah_id' => (string) $page['sura'],
                'ayah_index' => (string) $page['aya'],
                'ayah_key' => (string) $page['sura'].':'.$page['aya'],
            ]);
        }
    }
}
