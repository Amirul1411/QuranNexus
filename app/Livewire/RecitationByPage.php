<?php

namespace App\Livewire;

use App\Http\Controllers\PageController;
use Livewire\Component;
use Livewire\Attributes\Computed;
use App\Models\Page as PageModel;
use App\Models\Surah;

class RecitationByPage extends Component
{

    public $surahId;

    public $page;

    public function redirectToPage($pageId)
    {
      return redirect()->route('page.show', ['page' => (int) $pageId - 1]);
    }

    public function redirectToNextSurah($pageId)
    {
      return redirect()->route('page.show', ['page' => (int) $pageId + 1]);
    }

    // #[Computed()]
    // public function allPages()
    // {
    //     $pageController = new PageController();
    //     $allPages = $pageController->index();

    //     return $allPages;
    // }

    // #[Computed()]
    // public function page()
    // {
    //     return PageModel->getPage($this->surahId);
    // }

    public function render()
    {
        return view('livewire.recitation-by-page', [
            'page' => $this->page,
        ]);
    }
}
