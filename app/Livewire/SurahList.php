<?php

namespace App\Livewire;

use App\Models\Surah;
use Livewire\Component;

class SurahList extends Component
{

    public $selectedNavItem = 'all';

    public $surahs;

    public $search;

    public function redirectToRecitation($surahId)
    {
      return redirect()->route('surah.show', ['surah' => $surahId]);
    }

    public function render()
    {
        return view('livewire.surah-list', [
            'surahs' => $this->surahs,
        ]);
    }
}
