<?php

namespace App\Livewire;

use App\Models\Ayah;
use App\Models\Page;
use App\Models\Surah;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\Attributes\Computed;


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

    public function redirectToSurah($surahId)
    {
      return redirect()->route('surah.show', ['surah' => $surahId]);
    }

    public function redirectToPage($pageId)
    {
      return redirect()->route('page.show', ['page' => (int) $pageId]);
    }

    #[Computed()]
    public function bookmarkedSurah()
    {
        return Surah::find(Auth::user()->surah_bookmarks);
    }

    #[Computed()]
    public function bookmarkedAyah()
    {
        return Ayah::find(Auth::user()->ayah_bookmarks);
    }

    #[Computed()]
    public function bookmarkedPage()
    {
        return Page::find(Auth::user()->page_bookmarks);
    }

    public function render()
    {
        return view('livewire.surah-list', [
            'surahs' => $this->surahs,
        ]);
    }
}
