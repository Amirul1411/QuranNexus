<?php

namespace App\Livewire;

use App\Models\Ayah;
use Livewire\Component;

class AudioRecitationButton extends Component
{
    public $surah;

    public $page;

    public $juz;

    public $audioFiles = [];

    public function playAudioRecitation($ayahs)
    {
        $audioFiles = [];

        foreach ($ayahs as $ayahData) {
            $ayah = Ayah::find($ayahData['_id']);

            if ($ayah && $ayah->audioRecitations) {
                if($ayah->ayah_index == '1'){
                    $audioFiles[] = 'Alafasy/audhubillah.mp3';
                    if($ayah->bismillah){
                        $audioFiles[] = 'Alafasy/bismillah.mp3';
                    }
                }
                $audioFiles[] = $ayah->audioRecitations->audio_file;
            }
        }

        // Store the audio files in the public property
        $this->audioFiles = $audioFiles;
    }

    public function render()
    {
        return view('livewire.audio-recitation-button');
    }
}
