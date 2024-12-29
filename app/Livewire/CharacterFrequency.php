<?php

namespace App\Livewire;

use App\Models\CharacterFrequency as ModelsCharacterFrequency;
use Livewire\Component;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class CharacterFrequency extends Component implements HasForms, HasTable
{

    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(ModelsCharacterFrequency::query())
            ->columns([
                TextColumn::make('character')
                ->label('Character'),
                TextColumn::make('count')
                ->label('Count'),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                // ...
            ])
            ->bulkActions([
                // ...
            ]);
    }

    public function render()
    {
        return view('livewire.character-frequency');
    }
}
