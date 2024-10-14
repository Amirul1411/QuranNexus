<?php

namespace App\Livewire;

use App\Models\Ayah;
use Illuminate\Support\Facades\Auth;
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
            unlink($outputFile);
        }

        foreach ($ayahs as $ayahData) {
            $ayah = Ayah::find($ayahData['_id']);

            if(Auth::guest() || !isset(Auth::user()->settings['audio_id'])){
                if ($ayah && $ayah->audioRecitations) {
                    if ($ayah->ayah_index == '1') {
                        $audioFiles[] = 'Alafasy/mp3/audhubillah.mp3';
                        if ($ayah->bismillah) {
                            $audioFiles[] = 'Alafasy/mp3/bismillah.mp3';
                        }
                    }
                    $audioFiles[] = $ayah->audioRecitations->where('audio_info_id', '1')->first()->audio_url;
                }
            }else{
                if ($ayah && $ayah->audioRecitations) {
                    if ($ayah->ayah_index == '1') {
                        $audioFiles[] = 'AbdulBaset/Murattal/mp3/001000.mp3';
                        if ($ayah->bismillah) {
                            $audioFiles[] = 'AbdulBaset/Murattal/mp3/bismillah.mp3';
                        }
                    }
                    $audioFiles[] = $ayah->audioRecitations->where('audio_info_id', Auth::user()->settings['audio_id'])->first()->audio_url;
                }
            }

        }

        // Concatenate the audio files using FFmpeg
        if (!empty($audioFiles)) {
            $concatFile = storage_path('app/public/concat.txt');
            $concatContent = '';
            foreach ($audioFiles as $file) {
                $concatContent .= "file '" . public_path("audio/".$file) . "'\n";
            }

            // Write the file list to a temporary file
            file_put_contents($concatFile, $concatContent, LOCK_EX);

            // Run the FFmpeg command to concatenate the audio files
            $ffmpegCommand = "ffmpeg -f concat -safe 0 -i \"$concatFile\" -c:a libmp3lame -q:a 4 \"$outputFile\"";
            shell_exec($ffmpegCommand);

            // Store the path to the combined file
            $this->audioFile = asset('storage/combined_audio.mp3');
        }
    }

    public function render()
    {
        return view('livewire.audio-recitation-button');
    }
}
