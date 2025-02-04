<?php

namespace App\Livewire;

use App\Models\LongestToken as ModelsLongestToken;
use App\Models\Surah;
use Filament\Tables\Actions\Action;
use Livewire\Component;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Enums\FontFamily;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
use Illuminate\Support\Facades\Session;

class LongestToken extends Component implements HasForms, HasTable
{

    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(ModelsLongestToken::query())
            ->columns([
                TextColumn::make('_id')
                ->label('Id'),
                TextColumn::make('surah.name')
                ->fontFamily(FontFamily::Serif)
                ->size(TextColumnSize::Large)
                ->label('Chapter Name'),
                TextColumn::make('ayah_index')
                ->label('Ayah '),
                TextColumn::make('word_index')
                ->label('Word Index'),
                TextColumn::make('ayah_key')
                ->label('Ayah Key'),
                TextColumn::make('word_key')
                ->label('Word Key'),
                TextColumn::make('text')
                ->label('Word Text')
                ->size(TextColumnSize::Large)
                ->fontFamily(FontFamily::Serif),
                TextColumn::make('length')
                ->label('Length'),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                Action::make('View Token')
                ->button()
                ->outlined()
                ->color('success')
                ->action(function (ModelsLongestToken $record) {
                    $wordKey = $record->word_key;
                    [$surahNumber, $verseNumber, $tokenNumber] = explode(':', $wordKey);
                    $verseNumber = (int) $verseNumber;
                    $pageNumber = ceil($verseNumber / 10);

                    return redirect()
                    ->route('surah.show', [
                        'surah' => $surahNumber,
                        'page' => $pageNumber,
                    ])
                    ->with('scrollToAyah', $surahNumber . '-' . $verseNumber)
                    ->with('highlightToken', $surahNumber . '-' . $verseNumber . '-' . $tokenNumber);
                }),
            ])
            ->bulkActions([
                // ...
            ]);
    }

    public function render()
    {
        return view('livewire.longest-token');
    }
}
