<?php

namespace App\Livewire;

use Livewire\WithPagination;
use App\Models\Tafseer;
use Livewire\Component;

class RecitationByAyah extends Component
{
    use WithPagination;

    public $surah;

    public $page;

    public $juz;

    public function redirectToPreviousSurah($surahId)
    {
        return redirect()->route('surah.show', ['surah' => (int) $surahId - 1]);
    }

    public function redirectToNextSurah($surahId)
    {
        return redirect()->route('surah.show', ['surah' => (int) $surahId + 1]);
    }

    public function redirectToPreviousPage($pageId)
    {
        return redirect()->route('page.show', ['page' => (int) $pageId - 1]);
    }

    public function redirectToNextPage($pageId)
    {
        return redirect()->route('page.show', ['page' => (int) $pageId + 1]);
    }

    public function redirectToPreviousJuz($juzId)
    {
        return redirect()->route('juz.show', ['juz' => (int) $juzId - 1]);
    }

    public function redirectToNextJuz($juzId)
    {
        return redirect()->route('juz.show', ['juz' => (int) $juzId + 1]);
    }

    public function displayAyahTafseer($tafseerId)
    {
        $ayahKey = Tafseer::find($tafseerId)->ayah_key;

        return redirect()->route('tafseer.show', ['tafseer' => $ayahKey]);
    }

    public function displayWordInfo($wordText)
    {
        return $this->dispatch('openWordInfoModal', $wordText)->to('word-info-modal');
    }

    public function render()
    {

        if($this->surah != null) {
            $ayahs = $this->surah->ayahs()->paginate(10);
        }

        if($this->page != null) {
            $ayahs = $this->page->ayahs()->paginate(10);
        }

        if($this->juz != null) {
            $ayahs = $this->juz->ayahs()->paginate(10);
        }

        return view('livewire.recitation-by-ayah', [
            'surah' => $this->surah,
            'page' => $this->page,
            'juz' => $this->juz,
            'ayahs' => $ayahs,
        ]);
    }
}
