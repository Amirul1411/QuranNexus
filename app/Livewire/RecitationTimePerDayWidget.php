<?php

namespace App\Livewire;

use App\Models\User;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class RecitationTimePerDayWidget extends ChartWidget
{
    public $user;

    protected static ?string $heading = 'Total Recitation Time (minutes)';

    protected int|string|array $columnSpan = 'full';

    protected function getData(): array
    {
        // Initialize arrays to hold labels and total times
        $totalTimes = [];

        foreach ($this->user->recitation_times ?? [] as $date => $time) {
            // Only include dates within the last 7 days
            if (Carbon::parse($date)->isAfter(now()->subDays(7))) {
                if (!isset($totalTimes[$date])) {
                    $totalTimes[$date] = 0;
                }
                $totalTimes[$date] += $time;
            }
        }

        // Prepare data for the chart
        $labels = [];
        $times = [];
        $startDate = now()->subDays(6)->startOfDay(); // Start from 6 days ago to include today
        $endDate = now(); // Include today

        for ($date = $startDate; $date <= $endDate; $date->addDay()) {
            $formattedDate = $date->toDateString();
            $labels[] = $formattedDate;
            $times[] = $totalTimes[$formattedDate] ?? 0; // Default to 0 if no data
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Recitation Time (minutes)',
                    'data' => $times,
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                    'borderColor' => 'rgba(75, 192, 192, 1)',
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
