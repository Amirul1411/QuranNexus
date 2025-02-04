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

class SurahAnalysis extends Component implements HasForms, HasTable
{

    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(Surah::query())
            ->columns([
                TextColumn::make('_id')
                ->label('Id'),
                TextColumn::make('name')
                ->fontFamily(FontFamily::Serif)
                ->size(TextColumnSize::Large)
                ->label('Surah Name'),
                TextColumn::make('ayas')
                ->label('Number of Ayahs'),
                TextColumn::make('word_count')
                ->label('Number of Words'),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                Action::make('View Surah')
                ->button()
                ->outlined()
                ->color('success')
                ->url(fn (Surah $record): string => route('surah.show', ['surah' => Surah::where('name', $record->name)->first()->id])),
            ])
            ->bulkActions([
                // ...
            ]);
    }

    public function render()
    {
        return view('livewire.surah-analysis');
    }
}
