<?php

namespace App\Livewire;

use Livewire\Component;

class RecitationByAyah extends Component
{

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
        return redirect()->route('tafseer.show', ['tafseer' => $tafseerId]);
    }

    public function render()
    {
        return view('livewire.recitation-by-ayah', [
            'surah' => $this->surah,
            'page' => $this->page,
            'juz' => $this->juz,
        ]);
    }
}
