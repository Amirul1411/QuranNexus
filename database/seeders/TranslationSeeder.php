<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use MongoDB\Client as MongoClient;

class TranslationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Define the collection name
        $collectionName = 'translations';

        createDatabaseCollection($collectionName);

        $filePath = [resource_path('data\ms.basmeih.xml'), resource_path('data\en.sahih.xml')];

        foreach ($filePath as $file) {
            $xml = simplexml_load_file($file);

            foreach ($xml->sura as $sura) {
                foreach ($sura->aya as $aya) {
                    DB::table($collectionName)->insert([
                        '_id' => (string) getNextSequenceValue('translation_id'),
                        'translation_info_id' => (string) mapTranslationId($file),
                        'surah_id' => (string) $sura['index'],
                        'ayah_index' => (string) $aya['index'],
                        'ayah_key' => (string) $sura['index'] . ':' . $aya['index'],
                        'text' => (string) $aya['text'],
                    ]);
                }
            }
        }
    }
}
