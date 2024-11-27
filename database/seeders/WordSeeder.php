<?php

namespace Database\Seeders;

use App\Models\Ayah;
use App\Models\Page;
use App\Models\Word;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use MongoDB\Client as MongoClient;

class WordSeeder extends Seeder
{

    // !!! IMPORTANT !!!
    // !!! PLEASE READ THIS INSTRUCTION BEFORE ATTEMPTING TO RUN WORDSEEDER !!!

    // You can just run the wordseeder as normal if currently there is no record inside words collection
    // However, if you are attempting to run the wordseeder when there are already records inside words collection
    // You need to make sure that the last word document inside the words collection is in the middle of the ayah...and not at the end of the ayah
    // For example, if the last word document is inside ayah_key of 28:3 ... and there are a total number of 10 tokens inside 28:3
    // Make sure to only run the wordseeder if the word_key of the last word document is between 28:3:1 to 28:3:8
    // If not, then please manually delete some of the last word documents first until this condition is met
    // Don't run it at 28:3:9 as it will skip some of the supposed-to-be-inserted word document
    // Also, please be aware of the comment messages at line 129 - 136
    // Please ask if you don't understand this
    // Take note
    // Thanks
















    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $collectionName = 'words';

        createDatabaseCollection($collectionName);

        // $client = new MongoClient(env('DB_URI'));
        // $database = $client->selectDatabase(env('DB_DATABASE'));
        // $collection = $database->selectCollection($collectionName);

        // // Define your indexes (composite or single) with collation and unique options
        // $indexesToCreate = [
        //     [
        //         'fields' => ['ayah_key' => 1], // Index fields
        //         'collation' => [
        //             'locale' => 'en',
        //             'numericOrdering' => true,
        //         ],
        //         'unique' => false, // Unique
        //     ],
        //     [
        //         'fields' => ['word_key' => 1], // Index fields
        //         'collation' => [
        //             'locale' => 'en',
        //             'numericOrdering' => true,
        //         ],
        //         'unique' => true, // Not unique
        //     ],
        // ];

        // // Get existing indexes
        // $existingIndexes = $collection->listIndexes();
        // $existingIndexNames = [];

        // // Store existing index names
        // foreach ($existingIndexes as $index) {
        //     $existingIndexNames[] = $index->getName();
        // }

        // // Loop through your desired indexes and create them if they do not exist
        // foreach ($indexesToCreate as $indexConfig) {
        //     $indexFields = $indexConfig['fields'];
        //     $collation = $indexConfig['collation'];
        //     $unique = $indexConfig['unique'];

        //     // Generate a unique index name based on the fields
        //     $indexName = implode('_', array_keys($indexFields));

        //     // Check if the index already exists
        //     if (!in_array($indexName, $existingIndexNames)) {
        //         $options = [
        //             'name' => $indexName,
        //             'unique' => $unique, // Apply unique constraint if specified
        //         ];

        //         // Add collation to the options if it exists
        //         if ($collation) {
        //             $options['collation'] = $collation;
        //         }

        //         // Create the index
        //         $collection->createIndex($indexFields, $options);
        //     }
        // }

        // Seed database from jQuranTree

        // Include the JavaBridge library
        require 'http://localhost:8080/JavaBridge/java/Java.inc';

        $countWordCurrent = Word::count();
        $currentLastWord = null;
        // $currentLastWordIndex = false;
        // $lastApiWordArrIndex = false;

        if($countWordCurrent > 0){
            $currentLastWord = Word::find($countWordCurrent);
            $countAyahCurrent = (int) $currentLastWord->ayah->_id;

            if($currentLastWord->audio_url !== null){

                // Uncomment below if the currentLastWord word_key is less than 37:130:4
                $countAyahCurrent--;

                // Uncomment below if the currentLastWord word_key is above 37:130:4
                // $countAyahCurrent=$countAyahCurrent-2;
            }

        }else{
            $countAyahCurrent = 0;
        }

        $countWord = 1;

        try {
            // Create an instance of the Document class
            $document = new \Java('org.jqurantree.orthography.Document');

            // Call the getChapters method
            $tokensIterable = $document->getTokens();

            if ($tokensIterable instanceof \Java) {
                $iterator = $tokensIterable->iterator(); // Get an iterator

                while (java_is_true($iterator->hasNext())) {

                    $token = $iterator->next();
                    $characters = [];

                    // $tokenCount = java_cast($token->getVerse()->getTokenCount(), "int");

                    // if($currentLastWord !== null){
                    //     $currentLastWordIndex = $tokenCount === (int) $currentLastWord->word_index;
                    // }

                    // if( $currentLastWordIndex ){
                    //     $countAyahCurrent++;
                    // }

                    if ($countWordCurrent > 0 && $countWord <= ( $countWordCurrent - $countAyahCurrent)) {
                        $countWord++;
                        continue;
                    }

                    if(  (string) $token->getChapterNumber() === "37" && (string) $token->getVerseNumber() === "130" && (string) $token->getTokenNumber() === "4"){
                        continue;
                    }

                    $ayah = Ayah::where('surah_id', (string) $token->getChapterNumber())->where('ayah_index', (string) $token->getVerseNumber())->first();

                    $page = $ayah->page;
                    // $wordsArr = explode(' ', $ayah->text);

                    $response = Http::timeout(60)
                        ->retry(3, 1000)
                        ->get('https://api.quran.com/api/v4/verses/by_page/' . $page->id . '?words=true');

                    // Extract JSON data from the response
                    $data = $response->json();

                    // Loop through verses
                    foreach ($data['verses'] as $verse) {

                        // Access the verse_key property
                        $verseKey = $verse['verse_key'];

                        // $appendIndex = 0;

                        // Split the verse_key (e.g., "2:6") into surah_number and verse_number
                        [$surahNumber, $verseNumber] = explode(':', $verseKey);

                        // Loop through words within each verse
                        foreach ($verse['words'] as $index => $word) {

                            // Access the position property
                            $wordPosition = $word['position'];

                            $wordTextMatch = (string) $surahNumber === (string) $token->getChapterNumber() && (string) $verseNumber === (string) $token->getVerseNumber() && (string) $wordPosition === (string) $token->getTokenNumber();
                            $ayahIconMatch = (string) $surahNumber === (string) $token->getChapterNumber() && (string) $verseNumber === (string) $token->getVerseNumber() && $wordPosition === count($verse['words']);

                            // if ($wordTextMatch && !$lastApiWordArrIndex) {
                            if($wordTextMatch) {

                                // if($currentLastWordIndex){
                                //     $currentLastWordIndex = false;
                                //     $lastApiWordArrIndex = true;
                                //     $currentLastWord = null;
                                //     continue;
                                // }

                                // Construct the expected audio URL format based on surah, verse, and word position
                                $expectedAudioUrl = sprintf('wbw/%03d_%03d_%03d.mp3', $surahNumber, $verseNumber, $wordPosition);

                                // Check if the actual audio URL matches the expected format
                                if ($word['audio_url'] === $expectedAudioUrl) {
                                    $audioUrl = $word['audio_url'];
                                } else {
                                    // Overwrite with the correct audio URL if it does not match the expected format
                                    $audioUrl = $expectedAudioUrl;
                                }

                                // if(isWaqfSymbol($wordsArr[$index + $appendIndex])){
                                //     $tokenText = $token . $wordsArr[$index];
                                //     $appendIndex++;
                                // }else{
                                //     $tokenText = $token;
                                // }

                                if((string) $token->getChapterNumber() === "37" && (string) $token->getVerseNumber() === "130" && (string) $token->getTokenNumber() === "3"){
                                    $nextToken = $document->getToken(37,130,4);
                                    $tokenText = $token . " " . $nextToken;
                                }else{
                                    $tokenText = $token;
                                }

                                $tokenLength = java_cast($token->getLength(), 'int');

                                for ($i=0; $i < $tokenLength; $i++) {
                                    // Add the character type to the array
                                    $characters[] = java_cast($token->getCharacter($i)->toUnicode(), 'string');
                                }

                                if((string) $token->getChapterNumber() === "37" && (string) $token->getVerseNumber() === "130" && (string) $token->getTokenNumber() === "3"){

                                    $nextToken = $document->getToken(37,130,4);
                                    $nextTokenLength = java_cast($nextToken->getLength(), 'int');

                                    for ($i=0; $i < $nextTokenLength; $i++) {
                                        // Add the character type to the array
                                        $characters[] = java_cast($nextToken->getCharacter($i)->toUnicode(), 'string');
                                    }
                                }

                                DB::table($collectionName)->insert([
                                    '_id' => (string) getNextSequenceValue('word_id'),
                                    'surah_id' => (string) $token->getChapterNumber(),
                                    'ayah_index' => (string) $token->getVerseNumber(),
                                    'word_index' => (string) $token->getTokenNumber(),
                                    'ayah_key' => (string) $token->getChapterNumber() . ':' . $token->getVerseNumber(),
                                    'word_key' => (string) $token->getChapterNumber() . ':' . $token->getVerseNumber() . ':' . (string) $token->getTokenNumber(),
                                    'audio_url' => (string) $audioUrl,
                                    'page_id' => (string) $page->id,
                                    'line_number' => (int) $word['line_number'],
                                    'text' =>  (string) $tokenText,
                                    'characters' => $characters,
                                    // 'text' =>  (string) $wordsArr[$index],
                                    'translation' => (string) $word['translation']['text'],
                                    'transliteration' => (string) $word['transliteration']['text'],
                                ]);

                                if ((string) $token->getTokenNumber() ===  (string) (count($verse['words'])-1)){
                                    // $lastApiWordArrIndex = true;
                                    continue;
                                } else {
                                    break 2;
                                }
                            }

                            // if ($ayahIconMatch && $lastApiWordArrIndex) {
                            if($ayahIconMatch) {

                                // $lastApiWordArrIndex = false;

                                DB::table($collectionName)->insert([
                                    '_id' => (string) getNextSequenceValue('word_id'),
                                    'surah_id' => (string) $token->getChapterNumber(),
                                    'ayah_index' => (string) $token->getVerseNumber(),
                                    'word_index' => (string) $word['position'],
                                    'ayah_key' => (string) $token->getChapterNumber() . ':' . $token->getVerseNumber(),
                                    'word_key' => (string) $token->getChapterNumber() . ':' . $token->getVerseNumber() . ':' . (string) $word['position'],
                                    'audio_url' => $word['audio_url'] === "" ? null : $word['audio_url'],
                                    'page_id' => (string) $page->id,
                                    'line_number' => (int) $word['line_number'],
                                    'text' =>  (string) mapAyahNumberToNumberIcon( (string) $token->getVerseNumber()),
                                    'characters' => null,
                                    'translation' => (string) $word['translation']['text'],
                                    'transliteration' => $word['transliteration']['text'] === "" ? null : $word['transliteration']['text'],
                                ]);

                                break 2;
                            }
                        }
                    }
                }
            } else {
                echo 'The result from Java API is not an Iterable.';
            }
        } catch (\Exception $e) {
            echo 'Error accessing Java API: ' . $e->getMessage();
        }
    }
}
