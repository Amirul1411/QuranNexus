<?php

namespace App\Livewire;

use App\Models\Ayah;
use Livewire\Component;

class AudioRecitationButton extends Component
{
    public $surah;

    public $page;

    public $juz;

    public function playAudioRecitation($ayahs)
    {
        // Fetch the audio recitation files for the ayahs
        $audioFiles = [];

        foreach ($ayahs as $ayahData) {
            $ayah = Ayah::find($ayahData['_id']);

            // Check if the ayah has an associated audio file
            if ($ayah && $ayah->audioRecitations) {
                $audioFiles[] = $ayah->audioRecitations->audio_file;
            }

        }

        $this->dispatch('play-audio', ['audioFiles' => $audioFiles]);
    }

    public function render()
    {
        return view('livewire.audio-recitation-button');
    }
}
