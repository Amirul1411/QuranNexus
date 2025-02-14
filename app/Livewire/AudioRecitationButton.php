<?php

namespace App\Livewire;

use App\Models\Ayah;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\Attributes\On;

class AudioRecitationButton extends Component
{
    public $surah;

    public $page;

    public $juz;

    public $audioFile;

    public function playAudioRecitation($ayahs)
    {
        $audioFiles = [];
        $outputFileName = 'combined_audio.mp3';
        $outputFilePath = 'quran-audio/' . $outputFileName;
        $localOutputPath = Storage::disk('public')->path($outputFileName); // Local temporary file
        $concatFileName = 'concat.txt';
        $concatFilePath = 'quran-audio/' . $concatFileName;
        $localConcatPath = Storage::disk('public')->path($concatFileName); // Local temporary file for FFmpeg

        // Delete the existing combined file from S3 if it exists
        if (Storage::exists($outputFilePath)) {
            Storage::delete($outputFilePath);
        }

        foreach ($ayahs as $ayahData) {
            $ayah = Ayah::find($ayahData['_id']);

            if (Auth::guest() || !isset(Auth::user()->settings['audio_id'])) {
                if ($ayah && $ayah->audioRecitations) {
                    if ($ayah->ayah_index == '1') {
                        $audioFiles[] = Storage::url('quran-audio/Alafasy/mp3/audhubillah.mp3');
                        if ($ayah->bismillah) {
                            $audioFiles[] = Storage::url('quran-audio/Alafasy/mp3/bismillah.mp3');
                        }
                    }
                    $audioFiles[] = Storage::url('quran-audio/' . $ayah->audioRecitations->where('audio_info_id', '1')->first()->audio_url);
                }
            } else {
                if ($ayah && $ayah->audioRecitations) {
                    if ($ayah->ayah_index == '1' && Auth::user()->settings['audio_id'] === '1') {
                        $audioFiles[] = Storage::url('quran-audio/Alafasy/mp3/audhubillah.mp3');
                        if ($ayah->bismillah) {
                            $audioFiles[] = Storage::url('quran-audio/Alafasy/mp3/bismillah.mp3');
                        }
                    }elseif($ayah->ayah_index == '1' && Auth::user()->settings['audio_id'] === '2'){
                        $audioFiles[] = Storage::url('quran-audio/AbdulBaset/Murattal/mp3/001000.mp3');
                        if ($ayah->bismillah) {
                            $audioFiles[] = Storage::url('quran-audio/AbdulBaset/Murattal/mp3/bismillah.mp3');
                        }
                    }
                    $audioFiles[] = Storage::url('quran-audio/' . $ayah->audioRecitations->where('audio_info_id', Auth::user()->settings['audio_id'])->first()->audio_url);
                }
            }
        }

        // Concatenate the audio files using FFmpeg
        if (!empty($audioFiles)) {
            // Generate the content for the FFmpeg concat file
            $concatContent = '';
            foreach ($audioFiles as $file) {
                $concatContent .= "file '" . $file . "'\n";
            }

            // Write the concat file locally
            file_put_contents($localConcatPath, $concatContent);

            // Run the FFmpeg command to concatenate the audio files
            $ffmpegCommand = "ffmpeg -f concat -safe 0 -protocol_whitelist file,http,https,tcp,tls -i \"$localConcatPath\" -c:a libmp3lame -q:a 4 \"$localOutputPath\"";
            shell_exec($ffmpegCommand);

            // Upload the concat file to S3
            Storage::put($concatFilePath, file_get_contents($localConcatPath), 'public');

            // Upload the combined audio to S3
            if (file_exists($localOutputPath)) {
                Storage::put($outputFilePath, file_get_contents($localOutputPath), 'public');

                // Store the public URL of the combined file
                $this->audioFile = Storage::url($outputFilePath);
            }

            // Clean up local files
            @unlink($localConcatPath);
            @unlink($localOutputPath);
        }
    }

    public function render()
    {
        return view('livewire.audio-recitation-button');
    }
}
