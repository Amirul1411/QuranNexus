<?php

namespace App\Livewire;

use App\Http\Resources\V1\SurahResource;
use App\Models\Surah;
use Livewire\Component;

class Recitation extends Component
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
        return view('livewire.recitation',[
            'surah' => $this->surah,
            'ayah' => $this->surah->ayah,
        ]);
    }
}
