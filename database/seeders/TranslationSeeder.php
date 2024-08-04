<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TranslationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = resource_path('data\ms.basmeih.xml');

        $xml = simplexml_load_file($filePath);

        // Extract metadata
        $metadata = [
            'name' => (string) $xml['name'],
            'translator' => (string) $xml['translator'],
            'language' => (string) $xml['language']
        ];

        // Initialize an array to hold translations
        $translations = [];

        // Loop through the suras and ayas to collect translations
        foreach ($xml->sura as $sura) {
            foreach ($sura->aya as $aya) {
                $translations[] = [
                    'surah_id' => (string) $sura['index'],
                    'ayah_index' => (string) $aya['index'],
                    'text' => (string) $aya['text'],
                ];
            }
        }

        // Insert metadata and translations into the database
        DB::table('translations')->insert([
            '_id' => (string) getNextSequenceValue('translation_id'),
            'name' => $metadata['name'],
            'translator' => $metadata['translator'],
            'language' => $metadata['language'],
            'translation' => $translations,  // Insert as an array
        ]);
    }
}
