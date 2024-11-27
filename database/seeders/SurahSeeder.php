<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use MongoDB\Client as MongoClient;

class SurahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Define the collection name
        $collectionName = 'surahs';

        createDatabaseCollection($collectionName);

        // Seed database from XML file

        $filePath = Storage::url('quran-data\quran-data.xml');

        $xml = simplexml_load_file($filePath);

        foreach ($xml->suras->sura as $sura) {

            DB::table($collectionName)->insert([
                '_id' => (string) getNextSequenceValue('surah_id'),
                'name' => (string) $sura['name'],
                'tname' => (string) $sura['tname'],
                'ename' => (string) $sura['ename'],
                'type' => (string) $sura['type'],
                'ayas' => (int) $sura['ayas'],
            ]);
        }

        // Seed database from jQuranTree

        // Include the JavaBridge library
        // require("http://localhost:8080/JavaBridge/java/Java.inc");

        // try {
        //     // Create an instance of the Document class
        //     $document = new \Java('org.jqurantree.orthography.Document');

        //     // Call the getChapters method
        //     $chaptersIterable = $document->getChapters();

        //     if ($chaptersIterable instanceof \Java) {
        //         $iterator = $chaptersIterable->iterator(); // Get an iterator

        //         while (java_is_true($iterator->hasNext())) { // Limiting to first 10 chapters for testing
        //             $chapter = $iterator->next();

        //             // Call getName() on each chapter
        //             $name = $chapter->getName();

        //             DB::table('surahs')->insert([
        //                 '_id' => (string) getNextSequenceValue('surah_id'),
        //                 'name' => (string) $name,
        //             ]);
        //         }

        //     } else {
        //         echo "The result from Java API is not an Iterable.";
        //     }
        // } catch (\Exception $e) {
        //     echo "Error accessing Java API: " . $e->getMessage();
        // }
    }
}
