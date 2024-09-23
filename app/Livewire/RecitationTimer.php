<?php

namespace App\Livewire;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class RecitationTimer extends Component
{
    public $startTime;

    public function mount()
    {
        $this->startTime = now();
    }

    public function trackTimeSpent()
    {
        $endTime = now();

        $timeSpentInMinutes = round($this->startTime->diffInMinutes($endTime));

        Log::info('Track Time Spent:', [
            'startTime' => $this->startTime,
            'endTime' => $endTime,
            'timeSpentInSeconds' => $timeSpentInMinutes,
        ]);

        Auth::user()->trackRecitationTime($timeSpentInMinutes);
    }

    public function render()
    {
        return view('livewire.recitation-timer');
    }
}
