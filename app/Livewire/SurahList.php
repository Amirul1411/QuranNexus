<?php

namespace App\Livewire;

use App\Models\Ayah;
use App\Models\Juz;
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

    public function redirectToSurah($surahId)
    {
        return redirect()->route('surah.show', ['surah' => $surahId]);
    }

    public function redirectToAyah($ayahKey)
    {

        [$surahNumber, $verseNumber] = explode(':', $ayahKey);

        return redirect()
            ->route('surah.show', ['surah' => $surahNumber])
            ->with('scrollToAyah', $surahNumber . '-' . $verseNumber);
    }

    public function redirectToPage($pageId)
    {
        return redirect()->route('page.show', ['page' => (int) $pageId]);
    }

    public function redirectToJuz($juzId)
    {
        return redirect()->route('juz.show', ['juz' => (int) $juzId]);
    }

    #[Computed]
    public function bookmarkedSurah()
    {
        $bookmarks = Auth::user()->surah_bookmarks ?? [];
        $surahs = Surah::find($bookmarks);

        // Sort the surahs based on the order of the IDs in the bookmarks
        return $surahs
            ->sortByDesc(function ($surah) use ($bookmarks) {
                return array_search($surah->_id, $bookmarks);
            })
            ->values();
    }

    #[Computed]
    public function bookmarkedAyah()
    {
        $bookmarks = Auth::user()->ayah_bookmarks ?? [];
        $ayahs = Ayah::with('surah')->whereIn('_id', $bookmarks)->get();

        // Sort the ayahs based on the order of the IDs in the bookmarks
        return $ayahs
            ->sortByDesc(function ($ayah) use ($bookmarks) {
                return array_search($ayah->_id, $bookmarks);
            })
            ->values();
    }

    #[Computed]
    public function bookmarkedPage()
    {
        $bookmarks = Auth::user()->page_bookmarks ?? [];
        $pages = Page::find($bookmarks);

        // Sort the pages based on the order of the IDs in the bookmarks
        return $pages
            ->sortByDesc(function ($page) use ($bookmarks) {
                return array_search($page->_id, $bookmarks);
            })
            ->values();
    }

    #[Computed]
    public function recentlyReadSurah()
    {
        $recentlyRead = collect(Auth::user()->recently_read_surahs ?? [])
        ->pluck('item_id')
        ->toArray();

        $surahs = Surah::find($recentlyRead);

        // Sort the surahs based on the order of the IDs in recently_read_surahs
        return $surahs
            ->sortByDesc(function ($surah) use ($recentlyRead) {
                return array_search($surah->_id, $recentlyRead);
            })
            ->values();
    }

    #[Computed]
    public function recentlyReadJuz()
    {
        $recentlyRead = collect(Auth::user()->recently_read_juzs ?? [])
        ->pluck('item_id')
        ->toArray();

        $juzs = Juz::find($recentlyRead);

        // Sort the juzs based on the order of the IDs in recently_read_juzs
        return $juzs
            ->sortByDesc(function ($juz) use ($recentlyRead) {
                return array_search($juz->_id, $recentlyRead);
            })
            ->values();
    }

    #[Computed]
    public function recentlyReadPage()
    {
        $recentlyRead = collect(Auth::user()->recently_read_pages ?? [])
        ->pluck('item_id')
        ->toArray();

        $pages = Page::find($recentlyRead);

        // Sort the pages based on the order of the IDs in recently_read_pages
        return $pages
            ->sortByDesc(function ($page) use ($recentlyRead) {
                return array_search($page->_id, $recentlyRead);
            })
            ->values();
    }

    public function render()
    {
        return view('livewire.surah-list', [
            'surahs' => $this->surahs,
        ]);
    }
}
