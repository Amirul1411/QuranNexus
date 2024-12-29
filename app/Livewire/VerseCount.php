<?php

namespace App\Livewire;

use App\Models\Surah;
use App\Models\VerseCount as ModelsVerseCount;
use Livewire\Component;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Enums\FontFamily;
use Filament\Tables\Actions\Action;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextColumn\TextColumnSize;

class VerseCount extends Component implements HasForms, HasTable
{

    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(ModelsVerseCount::query())
            ->columns([
                TextColumn::make('chapter')
                ->fontFamily(FontFamily::Serif)
                ->size(TextColumnSize::Large)
                ->label('Chapter'),
                TextColumn::make('verseCount')
                ->label('Verse Count'),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                Action::make('View Surah')
                ->button()
                ->outlined()
                ->color('success')
                ->url(fn (ModelsVerseCount $record): string => route('surah.show', ['surah' => Surah::where('name', $record->chapter)->first()->id])),
            ])
            ->bulkActions([
                // ...
            ]);
    }

    public function render()
    {
        return view('livewire.verse-count');
    }
}
