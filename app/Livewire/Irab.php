<?php

namespace App\Livewire;

use App\Models\Irab as ModelsIrab;
use Livewire\Component;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class Irab extends Component implements HasForms, HasTable
{

    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(ModelsIrab::query())
            ->columns([
                TextColumn::make('location')
                ->label('Location'),
                TextColumn::make('form')
                ->label('Form')
                ->html(),
                TextColumn::make('tag')
                ->label('Tag'),
                TextColumn::make('features')
                ->label('Features'),
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
        return view('livewire.irab');
    }
}
