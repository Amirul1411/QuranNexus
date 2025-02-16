<?php

namespace App\Livewire;

use App\Models\WordStatistics as ModelsWordStatistics;
use Livewire\Component;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\Action;
use Livewire\Attributes\On;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
use Filament\Support\Enums\FontFamily;

class WordStatistics extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public $selectedWordStatistics = null;

    public function table(Table $table): Table
    {
        return $table
            ->query(ModelsWordStatistics::query())
            ->columns([
                TextColumn::make('_id')
                ->label('Id')
                ->sortable()
                ->searchable(),
                TextColumn::make('word')
                ->label('Word')
                ->sortable()
                ->searchable()
                ->fontFamily(FontFamily::Serif)
                ->size(TextColumnSize::Large),
                TextColumn::make('transliteration')
                ->label('Transliteration')
                ->sortable()
                ->searchable(),
                TextColumn::make('translation')
                ->label('Translation')
                ->sortable()
                ->searchable(),
                TextColumn::make('characters')
                ->label('Characters')
                ->fontFamily(FontFamily::Serif)
                ->size(TextColumnSize::Large),
                TextColumn::make('total_occurrences')
                ->label('Total Occurrences')
                ->sortable()
                ->searchable()
                ->alignCenter(),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                Action::make('Visualize')
                ->button()
                ->outlined()
                ->color('success')
                ->action(fn($record) => $this->visualizeWordStatistics($record->id))
            ])
            ->bulkActions([
                // ...
            ]);
    }

    public function visualizeWordStatistics($wordStatisticsId)
    {
        $this->selectedWordStatistics = ModelsWordStatistics::find($wordStatisticsId);
        $this->dispatch('wordStatisticsSelected', wordStatistics: $this->selectedWordStatistics);
    }

    #[On('plot-clicked')]
    public function redirectToWord($surahNumber, $verseNumber, $tokenNumber)
    {
        $pageNumber = ceil($verseNumber / 10);

        return redirect()
            ->route('surah.show', [
                'surah' => $surahNumber,
                'page' => $pageNumber,
            ])
            ->with('scrollToAyah', $surahNumber . '-' . $verseNumber)
            ->with('highlightToken', $surahNumber . '-' . $verseNumber . '-' . $tokenNumber);
    }

    public function render()
    {
        return view('livewire.word-statistics');
    }
}
