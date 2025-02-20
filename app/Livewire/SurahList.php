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
        $verseNumber = (int) $verseNumber;
        $pageNumber = ceil($verseNumber / 10);

        return redirect()
            ->route('surah.show', [
                'surah' => $surahNumber,
                'page' => $pageNumber,
            ])
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
        $bookmarks = Auth::user()->bookmarks ?? [];

        $surahIds = collect($bookmarks['chapters'] ?? [])
            ->map(function ($bookmark) {
                return [
                    'surah_id' => $bookmark['item_properties']['surah_id'],
                    'notes' => $bookmark['notes'],
                ];
            });

        $surahs = $surahIds->map(function ($item) {
            $surah = Surah::where('_id', $item['surah_id'])->first();
            if ($surah) {
                $surah->notes = $item['notes']; // Add notes to the Surah object
            }
            return $surah;
        });

        return $surahs;
    }

    #[Computed]
    public function bookmarkedAyah()
    {
        $bookmarks = Auth::user()->bookmarks ?? [];

        $ayahKeys = collect($bookmarks['verses'] ?? [])
            ->map(function ($bookmark) {
                return [
                    'ayah_key' => $bookmark['item_properties']['surah_id'] . ':' . $bookmark['item_properties']['ayah_index'],
                    'notes' => $bookmark['notes'],
                ];
            });

        $ayahs = $ayahKeys->map(function ($item) {
            $ayah = Ayah::with('surah')->where('ayah_key', $item['ayah_key'])->first();
            if ($ayah) {
                $ayah->notes = $item['notes']; // Add notes to the Surah object
            }
            return $ayah;
        });

        return $ayahs;
    }

    #[Computed]
    public function bookmarkedPage()
    {
        $bookmarks = Auth::user()->bookmarks ?? [];

        $pageIds = collect($bookmarks['pages'] ?? [])
            ->map(function ($bookmark) {
                return [
                    'page_id' => $bookmark['item_properties']['page_id'],
                    'notes' => $bookmark['notes'],
                ];
            });

        $pages = $pageIds->map(function ($item) {
            $page = Page::where('_id', $item['page_id'])->first();
            if ($page) {
                $page->notes = $item['notes']; // Add notes to the Surah object
            }
            return $page;
        });

        return $pages;
    }

    #[Computed]
    public function recentlyReadSurah()
    {
        $recentlyRead = Auth::user()->recently_read ?? [];

        $surahIds = collect($recentlyRead['chapters'] ?? [])->pluck('item_id')->toArray();

        $surahs = Surah::find($surahIds);

        // Sort the surahs based on the order of the IDs in recently_read
        return $surahs
            ->sortByDesc(function ($surah) use ($surahIds) {
                return array_search($surah->_id, $surahIds);
            })
            ->values();
    }

    #[Computed]
    public function recentlyReadJuz()
    {
        $recentlyRead = Auth::user()->recently_read ?? [];

        $juzIds = collect($recentlyRead['juzs'] ?? [])->pluck('item_id')->toArray();

        $juzs = Juz::find($juzIds);

        // Sort the juzs based on the order of the IDs in recently_read
        return $juzs
            ->sortByDesc(function ($juz) use ($juzIds) {
                return array_search($juz->_id, $juzIds);
            })
            ->values();
    }

    #[Computed]
    public function recentlyReadPage()
    {
        $recentlyRead = Auth::user()->recently_read ?? [];

        $pageIds = collect($recentlyRead['pages'] ?? [])->pluck('item_id')->toArray();

        $pages = Page::find($pageIds);

        // Sort the pages based on the order of the IDs in recently_read
        return $pages
            ->sortByDesc(function ($page) use ($pageIds) {
                return array_search($page->_id, $pageIds);
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
