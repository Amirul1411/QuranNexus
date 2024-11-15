<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use MongoDB\Client as MongoClient;

class TafseerInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Define the collection name
        $collectionName = 'tafseer_info';

        createDatabaseCollection($collectionName);

        $tafseerId = [169, 168];
        $response = Http::timeout(60)->retry(3, 1000)->get('https://api.quran.com/api/v4/resources/tafsirs');
        $data = $response->json();

        foreach ($tafseerId as $id) {
            foreach ($data['tafsirs'] as $tafsirs) {
                if ($tafsirs['id'] == $id) {
                    DB::table($collectionName)->insert([
                        '_id' => (string) getNextSequenceValue('tafseer_info_id'),
                        'name' => (string) $tafsirs['name'],
                        'author_name' => (string) $tafsirs['author_name'],
                        'slug' => (string) $tafsirs['slug'],
                        'language_name' => (string) $tafsirs['language_name'],
                        'translated_name' => $tafsirs['translated_name'],
                    ]);
                    break;
                }
            }
        }
    }
}
