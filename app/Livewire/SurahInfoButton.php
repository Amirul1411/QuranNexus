<?php

namespace App\Livewire;

use Livewire\Component;

class SurahInfoButton extends Component
{

    public $surah;

    public function displaySurahDetails($surahId)
    {
        return redirect()->route('surah_info.show', ['surah_info' => $surahId]);
    }

    public function render()
    {
        return view('livewire.surah-info-button');
    }
}
