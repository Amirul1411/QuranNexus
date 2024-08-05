<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Mp3File;
use Illuminate\Support\Facades\File;

class AlafasyByAyahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $folderPath = resource_path('data\al-afasy-audio\000_versebyverse'); // Adjust the path accordingly

        foreach (File::files($folderPath) as $file) {
            if ($file->getExtension() === 'mp3') {
                $fileName = $file->getFilename();
                $fileContent = File::get($file->getRealPath());

                Mp3File::create([
                    'filename' => $fileName,
                    'file' => new \MongoDB\BSON\Binary($fileContent, \MongoDB\BSON\Binary::TYPE_GENERIC),
                ]);

                $this->command->info("Imported: $fileName");
            }
        }

        $this->command->info('MP3 import completed.');
    }
}
