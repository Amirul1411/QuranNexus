<?php

use App\Models\Achievement;
use App\Models\AudioRecitation;
use App\Models\AudioRecitationInfo;
use App\Models\Ayah;
use App\Models\ChaptersInitials;
use App\Models\CharacterFrequency;
use App\Models\DailyQuotes;
use App\Models\DiacriticFrequency;
use App\Models\Inquiry;
use App\Models\Juz;
use App\Models\LongestToken;
use App\Models\Page;
use App\Models\Surah;
use App\Models\SurahInfo;
use App\Models\Tafseer;
use App\Models\TafseerInfo;
use App\Models\TestWord;
use App\Models\Translation;
use App\Models\TranslationInfo;
use App\Models\User;
use App\Models\Word;
use App\Models\WordStatistics;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use MongoDB\Operation\FindOneAndUpdate;
use MongoDB\Client as MongoClient;

if (!function_exists('getNextSequenceValue')) {
    function getNextSequenceValue($sequenceName)
    {
        // Get the MongoDB client
        $client = new MongoClient(env('DB_URI'));
        $database = $client->selectDatabase(env('DB_DATABASE'));
        $collection = $database->selectCollection('counters');

        $sequenceDocument = $collection->findOneAndUpdate(
            ['_id' => $sequenceName],
            ['$inc' => ['sequence_value' => 1]],
            ['returnDocument' => FindOneAndUpdate::RETURN_DOCUMENT_AFTER, 'upsert' => true]
        );

        return $sequenceDocument->sequence_value;
    }
}

if (!function_exists('resetCountersCollection')) {
    function resetCountersCollection()
    {
        // Define the collection name
        $collectionName = 'counters';

        createDatabaseCollection($collectionName);

        // Delete all existing documents in the 'counters' collection
        DB::collection($collectionName)->delete();

        // Insert initial documents for each collection counter
        DB::collection($collectionName)->insert([
            ['_id' => 'user_id', 'sequence_value' => User::count()],
            ['_id' => 'inquiry_id', 'sequence_value' => Inquiry::count()],
            ['_id' => 'surah_id', 'sequence_value' => Surah::count()],
            ['_id' => 'surah_info_id', 'sequence_value' => SurahInfo::count()],
            ['_id' => 'ayah_id', 'sequence_value' => Ayah::count()],
            ['_id' => 'word_id', 'sequence_value' => Word::count()],
            ['_id' => 'page_id', 'sequence_value' => Page::count()],
            ['_id' => 'juz_id', 'sequence_value' => Juz::count()],
            ['_id' => 'translation_id', 'sequence_value' => Translation::count()],
            ['_id' => 'translation_info_id', 'sequence_value' => TranslationInfo::count()],
            ['_id' => 'tafseer_id', 'sequence_value' => Tafseer::count()],
            ['_id' => 'tafseer_info_id', 'sequence_value' => TafseerInfo::count()],
            ['_id' => 'audio_id', 'sequence_value' => AudioRecitation::count()],
            ['_id' => 'audio_info_id', 'sequence_value' => AudioRecitationInfo::count()],
            ['_id' => 'achievement_id', 'sequence_value' => Achievement::count()],
            ['_id' => 'daily_quotes_id', 'sequence_value' => DailyQuotes::count()],
            ['_id' => 'chapters_initials_id', 'sequence_value' => ChaptersInitials::count()],
            ['_id' => 'character_frequency_id', 'sequence_value' => CharacterFrequency::count()],
            ['_id' => 'diacritic_frequency_id', 'sequence_value' => DiacriticFrequency::count()],
            ['_id' => 'longest_token_id', 'sequence_value' => LongestToken::count()],
            ['_id' => 'word_statistics_id', 'sequence_value' => WordStatistics::count()],
            // Add more collections as needed
        ]);
    }
}

if (!function_exists('createDatabaseCollection')) {
    function createDatabaseCollection($collectionName)
    {
        // Set up MongoDB client and specify the database
        $client = new MongoClient(env('DB_URI'));
        $database = $client->selectDatabase(env('DB_DATABASE'));

        // Check if the collection exists by listing collections
        $collectionExists = false;
        foreach ($database->listCollections() as $collection) {
            if ($collection->getName() === $collectionName) {
                $collectionExists = true;
                break;
            }
        }

        // Check if the collection is not exists
        if (!$collectionExists) {
            // Create collection with specified collation
            $database->createCollection($collectionName, [
                'collation' => [
                    'locale' => 'en',
                    'numericOrdering' => true,
                ],
            ]);
        }
    }
}

if (!function_exists('isWaqfSymbol')) {
    function isWaqfSymbol($word)
    {
        $waqfSymbols = [
            '۞',
            '۩',
            '۝',
            'ۖ',
            'ۗ',
            'ۚ',
            'ۛ',
            'ۜ',
            '۟',
            '۠',
            'ۡ',
            'ۢ',
            'ۣ',
            'ۤ',
            'ۥ',
            'ۦ',
        ];
        return in_array($word, $waqfSymbols, true);
    }
}

if (!function_exists('mapAudioRecitationId')) {
    function mapAudioRecitationId($id)
    {
        $map = [
            7 => 1,
            2 => 2,
        ];

        return $map[$id] ?? null;
    }
}

if (!function_exists('mapTranslationId')) {
    function mapTranslationId($filePath)
    {
        $map = [
            Storage::url('/quran-data/ms.basmeih.xml') => 1,
            Storage::url('/quran-data/en.sahih.xml') => 2,
        ];

        return $map[$filePath] ?? null;
    }
}

if (!function_exists('mapTafseerResourceId')) {
    function mapTafseerResourceId($id)
    {
        $map = [
            160 => 169,
            90 => 168,
        ];

        return $map[$id] ?? null;
    }
}

if (!function_exists('mapTafseerId')) {
    function mapTafseerId($id)
    {
        $map = [
            160 => 1,
            90 => 2,
        ];

        return $map[$id] ?? null;
    }
}

if (!function_exists('mapAyahNumberToNumberIcon')) {
    function mapAyahNumberToNumberIcon($ayaIndex)
    {
        $map = [
            1 => 'ﰀ',
            2 => 'ﰁ',
            3 => 'ﰂ',
            4 => 'ﰃ',
            5 => 'ﰄ',
            6 => 'ﰅ',
            7 => 'ﰆ',
            8 => 'ﰇ',
            9 => 'ﰈ',
            10 => 'ﰉ',
            11 => 'ﰊ',
            12 => 'ﰋ',
            13 => 'ﰌ',
            14 => 'ﰍ',
            15 => 'ﰎ',
            16 => 'ﰏ',
            17 => 'ﰐ',
            18 => 'ﰑ',
            19 => 'ﰒ',
            20 => 'ﰓ',
            21 => 'ﰔ',
            22 => 'ﰕ',
            23 => 'ﰖ',
            24 => 'ﰗ',
            25 => 'ﰘ',
            26 => 'ﰙ',
            27 => 'ﰚ',
            28 => 'ﰛ',
            29 => 'ﰜ',
            30 => 'ﰝ',
            31 => 'ﰞ',
            32 => 'ﰟ',
            33 => 'ﰠ',
            34 => 'ﰡ',
            35 => 'ﰢ',
            36 => 'ﰣ',
            37 => 'ﰤ',
            38 => 'ﰥ',
            39 => 'ﰦ',
            40 => 'ﰧ',
            41 => 'ﰨ',
            42 => 'ﰩ',
            43 => 'ﰪ',
            44 => 'ﰫ',
            45 => 'ﰬ',
            46 => 'ﰭ',
            47 => 'ﰮ',
            48 => 'ﰯ',
            49 => 'ﰰ',
            50 => 'ﰱ',
            51 => 'ﰲ',
            52 => 'ﰳ',
            53 => 'ﰴ',
            54 => 'ﰵ',
            55 => 'ﰶ',
            56 => 'ﰷ',
            57 => 'ﰸ',
            58 => 'ﰹ',
            59 => 'ﰺ',
            60 => 'ﰻ',
            61 => 'ﰼ',
            62 => 'ﰽ',
            63 => 'ﰾ',
            64 => 'ﰿ',
            65 => 'ﱀ',
            66 => 'ﱁ',
            67 => 'ﱂ',
            68 => 'ﱃ',
            69 => 'ﱄ',
            70 => 'ﱅ',
            71 => 'ﱆ',
            72 => 'ﱇ',
            73 => 'ﱈ',
            74 => 'ﱉ',
            75 => 'ﱊ',
            76 => 'ﱋ',
            77 => 'ﱌ',
            78 => 'ﱍ',
            79 => 'ﱎ',
            80 => 'ﱏ',
            81 => 'ﱐ',
            82 => 'ﱑ',
            83 => 'ﱒ',
            84 => 'ﱓ',
            85 => 'ﱔ',
            86 => 'ﱕ',
            87 => 'ﱖ',
            88 => 'ﱗ',
            89 => 'ﱘ',
            90 => 'ﱙ',
            91 => 'ﱚ',
            92 => 'ﱛ',
            93 => 'ﱜ',
            94 => 'ﱝ',
            95 => 'ﱞ',
            96 => 'ﱟ',
            97 => 'ﱠ',
            98 => 'ﱡ',
            99 => 'ﱢ',
            100 => 'ﱣ',
            101 => 'ﱤ',
            102 => 'ﱥ',
            103 => 'ﱦ',
            104 => 'ﱧ',
            105 => 'ﱨ',
            106 => 'ﱩ',
            107 => 'ﱪ',
            108 => 'ﱫ',
            109 => 'ﱬ',
            110 => 'ﱭ',
            111 => 'ﱮ',
            112 => 'ﱯ',
            113 => 'ﱰ',
            114 => 'ﱱ',
            115 => 'ﱲ',
            116 => 'ﱳ',
            117 => 'ﱴ',
            118 => 'ﱵ',
            119 => 'ﱶ',
            120 => 'ﱷ',
            121 => 'ﱸ',
            122 => 'ﱹ',
            123 => 'ﱺ',
            124 => 'ﱻ',
            125 => 'ﱼ',
            126 => 'ﱽ',
            127 => 'ﱾ',
            128 => 'ﱿ',
            129 => 'ﲀ',
            130 => 'ﲁ',
            131 => 'ﲂ',
            132 => 'ﲃ',
            133 => 'ﲄ',
            134 => 'ﲅ',
            135 => 'ﲆ',
            136 => 'ﲇ',
            137 => 'ﲈ',
            138 => 'ﲉ',
            139 => 'ﲊ',
            140 => 'ﲋ',
            141 => 'ﲌ',
            142 => 'ﲍ',
            143 => 'ﲎ',
            144 => 'ﲏ',
            145 => 'ﲐ',
            146 => 'ﲑ',
            147 => 'ﲒ',
            148 => 'ﲓ',
            149 => 'ﲔ',
            150 => 'ﲕ',
            151 => 'ﲖ',
            152 => 'ﲗ',
            153 => 'ﲘ',
            154 => 'ﲙ',
            155 => 'ﲚ',
            156 => 'ﲛ',
            157 => 'ﲜ',
            158 => 'ﲝ',
            159 => 'ﲞ',
            160 => 'ﲟ',
            161 => 'ﲠ',
            162 => 'ﲡ',
            163 => 'ﲢ',
            164 => 'ﲣ',
            165 => 'ﲤ',
            166 => 'ﲥ',
            167 => 'ﲦ',
            168 => 'ﲧ',
            169 => 'ﲨ',
            170 => 'ﲩ',
            171 => 'ﲪ',
            172 => 'ﲫ',
            173 => 'ﲬ',
            174 => 'ﲭ',
            175 => 'ﲮ',
            176 => 'ﲯ',
            177 => 'ﲰ',
            178 => 'ﲱ',
            179 => 'ﲲ',
            180 => 'ﲳ',
            181 => 'ﲴ',
            182 => 'ﲵ',
            183 => 'ﲶ',
            184 => 'ﲷ',
            185 => 'ﲸ',
            186 => 'ﲹ',
            187 => 'ﲺ',
            188 => 'ﲻ',
            189 => 'ﲼ',
            190 => 'ﲽ',
            191 => 'ﲾ',
            192 => 'ﲿ',
            193 => 'ﳀ',
            194 => 'ﳁ',
            195 => 'ﳂ',
            196 => 'ﳃ',
            197 => 'ﳄ',
            198 => 'ﳅ',
            199 => 'ﳆ',
            200 => 'ﳇ',
            201 => 'ﳈ',
            202 => 'ﳉ',
            203 => 'ﳊ',
            204 => 'ﳋ',
            205 => 'ﳌ',
            206 => 'ﳍ',
            207 => 'ﳎ',
            208 => 'ﳏ',
            209 => 'ﳐ',
            210 => 'ﳑ',
            211 => 'ﳒ',
            212 => 'ﳓ',
            213 => 'ﳔ',
            214 => 'ﳕ',
            215 => 'ﳖ',
            216 => 'ﳗ',
            217 => 'ﳘ',
            218 => 'ﳙ',
            219 => 'ﳚ',
            220 => 'ﳛ',
            221 => 'ﳜ',
            222 => 'ﳝ',
            223 => 'ﳞ',
            224 => 'ﳟ',
            225 => 'ﳠ',
            226 => 'ﳡ',
            227 => 'ﳢ',
            228 => 'ﳣ',
            229 => 'ﳤ',
            230 => 'ﳥ',
            231 => 'ﳦ',
            232 => 'ﳧ',
            233 => 'ﳨ',
            234 => 'ﳩ',
            235 => 'ﳪ',
            236 => 'ﳫ',
            237 => 'ﳬ',
            238 => 'ﳭ',
            239 => 'ﳮ',
            240 => 'ﳯ',
            241 => 'ﳰ',
            242 => 'ﳱ',
            243 => 'ﳲ',
            244 => 'ﳳ',
            245 => 'ﳴ',
            246 => 'ﳵ',
            247 => 'ﳶ',
            248 => 'ﳷ',
            249 => 'ﳸ',
            250 => 'ﳹ',
            251 => 'ﳺ',
            252 => 'ﳻ',
            253 => 'ﳼ',
            254 => 'ﳽ',
            255 => 'ﳾ',
            256 => 'ﳿ',
            257 => 'ﴀ',
            258 => 'ﴁ',
            259 => 'ﴂ',
            260 => 'ﴃ',
            261 => 'ﴄ',
            262 => 'ﴅ',
            263 => 'ﴆ',
            264 => 'ﴇ',
            265 => 'ﴈ',
            266 => 'ﴉ',
            267 => 'ﴊ',
            268 => 'ﴋ',
            269 => 'ﴌ',
            270 => 'ﴍ',
            271 => 'ﴎ',
            272 => 'ﴏ',
            273 => 'ﴐ',
            274 => 'ﴑ',
            275 => 'ﴒ',
            276 => 'ﴓ',
            277 => 'ﴔ',
            278 => 'ﴕ',
            279 => 'ﴖ',
            280 => 'ﴗ',
            281 => 'ﴘ',
            282 => 'ﴙ',
            283 => 'ﴚ',
            284 => 'ﴛ',
            285 => 'ﴜ',
            286 => 'ﴝ',
        ];

        return $map[$ayaIndex] ?? null;
    }
}

if (!function_exists('mapSurahNumberToSurahFont')) {
    function mapSurahNumberToSurahFont($surahId)
    {
        $map = [
            1 => '!',
            2 => '"',
            3 => '#',
            4 => '$',
            5 => '%',
            6 => '&',
            7 => "'",
            8 => '(',
            9 => ')',
            10 => '*',
            11 => '+',
            12 => ',',
            13 => '-',
            14 => '.',
            15 => '/',
            16 => '0',
            17 => '1',
            18 => '2',
            19 => '3',
            20 => '4',
            21 => '5',
            22 => '6',
            23 => '7',
            24 => '8',
            25 => '9',
            26 => ':',
            27 => ';',
            28 => '<',
            29 => '=',
            30 => '>',
            31 => '?',
            32 => '@',
            33 => 'a',
            34 => 'A',
            35 => 'b',
            36 => 'B',
            37 => 'c',
            38 => 'C',
            39 => 'd',
            40 => 'D',
            41 => 'E',
            42 => 'e',
            43 => 'F',
            44 => 'f',
            45 => 'g',
            46 => 'G',
            47 => 'H',
            48 => 'h',
            49 => 'I',
            50 => 'i',
            51 => 'J',
            52 => 'j',
            53 => 'K',
            54 => 'k',
            55 => 'l',
            56 => 'L',
            57 => 'M',
            58 => 'm',
            59 => 'n',
            60 => 'N',
            61 => 'O',
            62 => 'o',
            63 => 'p',
            64 => 'P',
            65 => 'Q',
            66 => 'q',
            67 => 'R',
            68 => 'r',
            69 => 's',
            70 => 'S',
            71 => 't',
            72 => 'T',
            73 => 'u',
            74 => 'U',
            75 => 'v',
            76 => 'V',
            77 => 'W',
            78 => 'w',
            79 => 'x',
            80 => 'X',
            81 => 'y',
            82 => 'Y',
            83 => 'Z',
            84 => 'z',
            85 => '[',
            86 => '\\',
            87 => ']',
            88 => '^',
            89 => '_',
            90 => '`',
            91 => '{',
            92 => '|',
            93 => '}',
            94 => '~',
            95 => '¡',
            96 => '¢',
            97 => '£',
            98 => '¤',
            99 => '¥',
            100 => '¦',
            101 => '§',
            102 => '¨',
            103 => '©',
            104 => 'ª',
            105 => '«',
            106 => '¬',
            107 => '®­',
            108 => '¯',
            109 => '°',
            110 => '±',
            111 => '²',
            112 => '³',
            113 => '´',
            114 => 'µ',
        ];

        return $map[$surahId] ?? null;
    }
}

