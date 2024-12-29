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

class DiacriticFrequency extends Component implements HasForms, HasTable
{

    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(ModelsDiacriticFrequency::query())
            ->columns([
                TextColumn::make('diacritic')
                ->label('Diacritic'),
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
        return view('livewire.diacritic-frequency');
    }
}
