<?php

namespace App\Livewire;

use Filament\Widgets\ChartWidget;
use Filament\Support\RawJs;

class WordDistributionAnalysisChart extends ChartWidget
{
    protected static ?string $heading = 'Percentage Word Distribution by Juz (%)';

    protected int|string|array $columnSpan = 'full';

    protected static string $color = 'success';

    public $wordStatistics;

    protected function getData(): array
    {
        // Initialize arrays for labels and percentages
        $labels = [];
        $percentages = [];

        $backgroundColors = ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40', '#C9CBCF', '#F7464A', '#46BFBD', '#FDB45C', '#949FB1', '#4D5360', '#FF6F61', '#6B5B95', '#88B04B', '#F7CAC9', '#92A8D1', '#955251', '#B565A7', '#009B77', '#DD4124', '#D65076', '#45B8AC', '#EFC050', '#5B5EA6', '#9B2335', '#DFCFBE', '#55B4B0', '#E15D44', '#7FCDCD'];

        // Calculate total occurrences
        $totalOccurrences = $this->wordStatistics->total_occurrences;

        // Calculate percentage for each Juz
        foreach ($this->wordStatistics->occurrences_by_juz as $juzOccurrence) {
            $juzId = $juzOccurrence['juz_id'];
            $count = $juzOccurrence['count'];

            // Calculate percentage
            $percentage = ($count / $totalOccurrences) * 100;

            // Add to labels and percentages arrays
            $labels[] = "Juz {$juzId}";
            $percentages[] = round($percentage, 2); // Round to 2 decimal places
        }

        return [
            'datasets' => [
                [
                    'label' => 'Percentage Word Distribution by Juz',
                    'data' => $percentages,
                    'backgroundColor' => $backgroundColors, // Custom colors for each Juz
                    'borderColor' => '#fff', // Border color for the doughnut chart
                    'borderWidth' => 2, // Border width for the doughnut chart
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): RawJs
    {
        return RawJs::make(
            <<<JS
                {
                   onClick: function(event,elements) {
                    const clickedIndex = elements[0].index;

                        // Get the label and value of the clicked segment
                        const label = this.data.labels[clickedIndex];
                        const value = this.data.datasets[0].data[clickedIndex];

                        // Display an alert with the clicked segment's details
                        alert('You clicked on ' + label + ' with a value of ' + value + '%');
                    }
                }
            JS
            ,
        );
    }
}
