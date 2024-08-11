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

        // Seed database from XML file

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

        // Seed database from jQuranTree

        // Include the JavaBridge library
        // require_once("http://localhost:8080/JavaBridge/java/Java.inc");

        // try {
        //     // Create an instance of the Document class
        //     $document = new \Java('org.jqurantree.orthography.Document');

        //     // Call the getChapters method
        //     $chaptersIterable = $document->getChapters();

        //     $chaptersArray = [];
        //         $iterator = $chaptersIterable->iterator(); // Assuming iterator() returns an iterator

        //         while ($iterator->hasNext()) {
        //             $chapter = $iterator->next();
        //             $chaptersArray[] = $chapter;
        //         }

        //         // Process each Chapter object
        //         foreach ($chaptersArray as $chapter) {
        //             // Call getName() on each Chapter object
        //             $name = $chapter->getName();

        //             // Assuming getName() returns a Java String object
        //             $nameString = $name->toString(); // Convert Java String to PHP string

        //             DB::table('surahs')->insert([
        //                 '_id' => (string) getNextSequenceValue('surah_id'),
        //                 'name' => (string) $nameString,
        //                 // 'tname' => (string) $sura['tname'],
        //                 // 'ename' => (string) $sura['ename'],
        //                 // 'ayas' => (int) $sura['ayas'],
        //             ]);
        //         }
        // } catch (\Exception $e) {
        //     // Catch any exceptions thrown by the Java Bridge
        //     echo "Error: " . $e->getMessage();
        // }
    }
}
