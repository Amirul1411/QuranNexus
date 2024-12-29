<?php

namespace App\Livewire;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class UserRecitationWidget extends BaseWidget
{

    public $user;

    protected function getStats(): array
    {

        $this->user = Auth::user();

        return [
            Stat::make('Current Streak', $this->user->recitation_streak ?? 0),
            Stat::make('Longest Streak', $this->user->longest_streak ?? 0),
            Stat::make('Last Recitation Date', $this->user->last_recitation_date ?? 'N/A'),
        ];
    }
}
