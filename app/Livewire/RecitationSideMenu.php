<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Computed;
use App\Http\Controllers\Api\V1\APISurahController;
use App\Http\Controllers\PageController;
use App\Models\Juz;
use App\Models\Page;

class RecitationSideMenu extends Component
{

    public $search;

    public function redirectToSurah($surahId)
    {
      return redirect()->route('surah.show', ['surah' => (int) $surahId]);
    }

    public function redirectToJuz($juzId)
    {
      return;
    }

    public function redirectToPage($pageId)
    {
      return redirect()->route('page.show', ['page' => (int) $pageId]);;
    }

    #[Computed()]
    public function allSurahs()
    {
        $apiController = new APISurahController();
        $allSurahs = $apiController->index();

        return $allSurahs;
    }

    #[Computed()]
    public function allJuzs()
    {
        return Juz::all();
    }

    #[Computed()]
    public function allPages()
    {
        $pageController = new PageController();
        $allPages = $pageController->index();

        return $allPages;
    }

    public function render()
    {
        return view('livewire.recitation-side-menu');
    }
}
