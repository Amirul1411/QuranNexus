<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use MongoDB\Client as MongoClient;

class TranslationInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Define the collection name
        $collectionName = 'translation_info';

        createDatabaseCollection($collectionName);

        $filePath = [Storage::url('quran-data\ms.basmeih.xml'), Storage::url('quran-data\en.sahih.xml')];

        foreach ($filePath as $file) {
            $xml = simplexml_load_file($file);

            DB::table($collectionName)->insert([
                '_id' => (string) getNextSequenceValue('translation_info_id'),
                'name' => (string) $xml['name'],
                'translator' => (string) $xml['translator'],
                'language' => (string) $xml['language'],
            ]);
        }
    }
}
