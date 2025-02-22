<?php

namespace App\Livewire;

use App\Http\Controllers\PageController;
use Livewire\Component;
use Livewire\Attributes\Computed;
use App\Models\Page;
use App\Models\Surah;

class RecitationByPage extends Component
{

    public $surah;

    public $page;

    public $juz;

    public function redirectToPreviousPage($pageId)
    {
        return redirect()->route('page.show', ['page' => (int) $pageId - 1]);
    }

    public function redirectToNextPage($pageId)
    {
        return redirect()->route('page.show', ['page' => (int) $pageId + 1]);
    }

    public function displayWordInfo($wordText)
    {
        return $this->dispatch('openWordInfoModal', $wordText)->to('word-info-modal');
    }

    public function render()
    {
        return view('livewire.recitation-by-page', [
            'page' => $this->page,
        ]);
    }
}
