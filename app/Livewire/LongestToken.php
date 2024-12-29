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
                TextColumn::make('chapter')
                ->fontFamily(FontFamily::Serif)
                ->size(TextColumnSize::Large)
                ->label('Chapter Name'),
                TextColumn::make('verse')
                ->label('Verse Number'),
                TextColumn::make('token_number')
                ->label('Token Number'),
                TextColumn::make('token')
                ->label('Token')
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
                ->url(function (ModelsLongestToken $record): string {
                    $surahId = Surah::where('name', $record->chapter)->first()->id;
                    $scrollToAyah = $record->verse . '-' . $record->token_number;
                    $highlightToken = $surahId . '-' . $record->verse . '-' . $record->token_number;

                    // Set session values
                    Session::put('scrollToAyah', $scrollToAyah);
                    Session::put('highlightToken', $highlightToken);

                    // Generate and return the URL
                    return route('surah.show', ['surah' => $surahId]);
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
