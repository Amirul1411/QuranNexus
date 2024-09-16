<?php

namespace App\Livewire;

use App\Models\Surah;
use Livewire\Component;
use Livewire\Attributes\Url;

class SurahList extends Component
{

    public $selectedNavItem = 'all';

    public $surahs;

    public $search = '';

    public function updatedSearch()
    {
        // General search across multiple fields
        $this->surahs = Surah::where(function ($query) {
                $query->where('tname', 'like', '%' . $this->search . '%')
                    ->orWhere('ename', 'like', '%' . $this->search . '%')
                    ->orWhere('_id', $this->search);
            })->get();
    }

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
