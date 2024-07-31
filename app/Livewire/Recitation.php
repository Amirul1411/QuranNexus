<?php

namespace App\Livewire;

use App\Http\Controllers\Api\V1\APISurahController;
use App\Http\Resources\V1\SurahResource;
use App\Models\Surah;
use Livewire\Component;
use Livewire\Attributes\Computed;

class Recitation extends Component
{
    public $surah;

    public function redirectToPreviousSurah($surahId)
    {
      return redirect()->route('surah.show', ['surah' => (int) $surahId - 1]);
    }

    public function redirectToNextSurah($surahId)
    {
      return redirect()->route('surah.show', ['surah' => (int) $surahId + 1]);
    }

    #[Computed()]
    public function allSurahs()
    {
        $apiController = new APISurahController();
        $response = $apiController->index();
        $allSurahs = $response->toArray();

        return $allSurahs;
    }

    public function render()
    {
        return view('livewire.recitation',[
            'surah' => $this->surah,
        ]);
    }
}
