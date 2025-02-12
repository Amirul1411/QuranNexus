<?php

namespace App\Livewire;

use App\Models\DiacriticFrequency as ModelsDiacriticFrequency;
use Livewire\Component;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\Action;
use Livewire\Attributes\On;

class DiacriticFrequency extends Component implements HasForms, HasTable
{

    use InteractsWithTable;
    use InteractsWithForms;

    public $selectedDiacritic = null;

    public function table(Table $table): Table
    {
        return $table
            ->query(ModelsDiacriticFrequency::query())
            ->columns([
                TextColumn::make('_id')
                ->label('Id')
                ->sortable()
                ->searchable(),
                TextColumn::make('diacritic')
                ->label('Diacritic')
                ->sortable()
                ->searchable(),
                TextColumn::make('count')
                ->label('Count')
                ->sortable()
                ->searchable(),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                Action::make('Visualize')
                ->button()
                ->outlined()
                ->color('success')
                ->action(fn($record) => $this->visualizeDiacritic($record->id)),
            ])
            ->bulkActions([
                // ...
            ]);
    }

    public function visualizeDiacritic($diacriticId)
    {
        $this->selectedDiacritic = ModelsDiacriticFrequency::find($diacriticId);
        $this->dispatch('diacriticSelected', diacritic: $this->selectedDiacritic);
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
        return view('livewire.diacritic-frequency');
    }
}
