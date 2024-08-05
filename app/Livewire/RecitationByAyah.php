<?php

namespace App\Livewire;

use Livewire\Component;

class RecitationByAyah extends Component
{

    public $surah;

    public function redirectToPreviousSurah($surahId)
    {
      return redirect()->route('surah.show', ['surah' => (int) $surahId - 1]);
    }

    public function redirectToNextSurah($surahId)
    {
      return redirect()->route('surah.show', ['surah' => (int) $surahId + 1]);
    }

    public function render()
    {
        return view('livewire.recitation-by-ayah', [
            'surah' => $this->surah,
        ]);
    }
}
