<?php

namespace App\Livewire;

use App\Models\Surah;
use App\Models\Word;
use App\Models\WordStatistics;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;
use Filament\Support\RawJs;

class BookmarkedWordBySurahChart extends ChartWidget
{
    public $user;

    protected static ?string $heading = 'Percentage User\'s Word Vocabularies by Surah (%)';

    protected int|string|array $columnSpan = 'full';

    protected static string $color = 'success';

    protected function getData(): array
    {
        $this->user = Auth::user();

        $surahs = Surah::all();

        // Initialize arrays for labels and percentages
        $labels = [];
        $percentages = [];

        // Get the user's bookmarked words
        $bookmarkedWords = $this->user->bookmarks['words'] ?? [];

        // Extract word_statistics_id from bookmarked words
        $wordStatisticsItemProperties = array_column($bookmarkedWords, 'item_properties') ?? [];
        $wordStatisticsIds = array_column($wordStatisticsItemProperties, 'word_statistics_id') ?? [];

        foreach ($surahs as $surah) {
            // Get the total word count for the surah
            $totalWordCount = $surah->word_count;

            // Count the number of bookmarked words in this surah
            $bookmarkedWordCount = WordStatistics::whereIn('_id', $wordStatisticsIds)
                ->where('positions.word_keys', 'regexp', '/^' . $surah->_id . ':/') // Filter by surah_id in the word_keys string
                ->count();

            // Calculate the percentage of bookmarked words
            $percentage = $bookmarkedWordCount > 0 ? ($bookmarkedWordCount / $totalWordCount) * 100 : 0;

            // Add to the labels and percentages arrays
            $labels[] = $surah->name; // Assuming the Surah model has a `name` attribute
            $percentages[] = round($percentage, 2); // Round to 2 decimal places
        }

        return [
            'datasets' => [
                [
                    'label' => 'Percentage User\'s Word Vocabularies by Surah (%)',
                    'data' => $percentages,
                    'backgroundColor' => 'rgba(46, 125, 50, 0.2)', // Lighter green for the plot fill
                    'borderColor' => 'rgba(46, 125, 50, 1)', // Darker green for the line
                    'borderWidth' => 1, // Slightly thicker line for better visibility
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'radar';
    }

    protected function getOptions(): RawJs
    {
        return RawJs::make(
            <<<JS
                {
                   onClick: function(event,elements) {
                    //   console.log(elements, event);
                    }
                }
            JS
            ,
        );
    }
}
