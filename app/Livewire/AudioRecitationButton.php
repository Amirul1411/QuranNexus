<?php

namespace App\Livewire;

use App\Models\Ayah;
use Livewire\Component;

class AudioRecitationButton extends Component
{
    public $surah;

    public $page;

    public $juz;

    public $audioFile;

    public function playAudioRecitation($ayahs)
    {
        $audioFiles = [];
        $outputFile = storage_path('app/public/combined_audio.mp3');

        if (file_exists($outputFile)) {
            $rmCommand = "rm \"$outputFile\"";
            shell_exec($rmCommand);
        }

        foreach ($ayahs as $ayahData) {
            $ayah = Ayah::find($ayahData['_id']);

            if ($ayah && $ayah->audioRecitations) {
                if ($ayah->ayah_index == '1') {
                    $audioFiles[] = 'Alafasy/audhubillah.mp3';
                    if ($ayah->bismillah) {
                        $audioFiles[] = 'Alafasy/bismillah.mp3';
                    }
                }
                $audioFiles[] = $ayah->audioRecitations->audio_file;
            }
        }

        // Concatenate the audio files using FFmpeg
        if (!empty($audioFiles)) {
            $concatFile = storage_path('app/public/concat.txt');
            $concatContent = '';
            foreach ($audioFiles as $file) {
                $concatContent .= "file '" . public_path($file) . "'\n";
            }

            // Write the file list to a temporary file
            file_put_contents($concatFile, $concatContent, LOCK_EX);

            // Run the FFmpeg command to concatenate the audio files
            $ffmpegCommand = "ffmpeg -f concat -safe 0 -i \"$concatFile\" -c copy \"$outputFile\"";
            shell_exec($ffmpegCommand);

            // Store the path to the combined file
            $this->audioFile = asset($outputFile);
        }
    }

    public function render()
    {
        return view('livewire.audio-recitation-button');
    }
}
