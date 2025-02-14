<?php

namespace App\Livewire;

use App\Models\CharacterFrequency as ModelsCharacterFrequency;
use Filament\Forms\Components\TextInput;
use Livewire\Component;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\Action;
use Livewire\Attributes\On;

class CharacterFrequency extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public $selectedCharacter = null;

    public function table(Table $table): Table
    {
        return $table
            ->query(ModelsCharacterFrequency::query())
            ->columns([
                TextColumn::make('_id')
                ->label('Id')
                ->sortable()
                ->searchable(),
                TextColumn::make('character')
                ->label('Character')
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
            ->actions([Action::make('Visualize')->button()->outlined()->color('success')->action(fn($record) => $this->visualizeCharacter($record->id))])
            ->bulkActions([
                // ...
            ]);
    }

    public function visualizeCharacter($characterId)
    {
        $this->selectedCharacter = ModelsCharacterFrequency::find($characterId);
        $this->dispatch('characterSelected', character: $this->selectedCharacter);
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
        return view('livewire.character-frequency');
    }
}
