<?php

namespace App\Filament\Resources\SurahResource\RelationManagers;

use App\Models\Ayah;
use App\Models\Word;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Enums\FontFamily;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AyahRelationManager extends RelationManager
{
    protected static string $relationship = 'ayahs';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('ayah_index')
                ->readOnly()
                ->label('Ayah Index'),
                TextInput::make('ayah_key')
                ->readOnly()
                ->label('Ayah Key'),
                TextInput::make('page_id')
                ->readOnly()
                ->label('Page Number'),
                TextInput::make('juz_id')
                ->readOnly()
                ->label('Juz Number'),
                Repeater::make('words')
                ->relationship()
                ->schema([
                    Placeholder::make('word_key')
                    ->label('Word Key')
                    ->content(fn (Word $record): string => $record->word_key),
                    TextInput::make('text')
                    ->required(),
                ])
                ->columnSpanFull()
                ->addable(false)
                ->deletable(false),
                Toggle::make('isVerified')
                ->label('Is Verified'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Ayah')
            ->columns([
                TextColumn::make('ayah_index')
                ->sortable()
                ->searchable()
                ->label('Ayah Index')
                ->alignCenter(),
                TextColumn::make('ayah_key')
                ->sortable()
                ->searchable()
                ->label('Ayah Key')
                ->alignCenter(),
                TextColumn::make('page_id')
                ->sortable()
                ->searchable()
                ->label('Page Number')
                ->alignCenter(),
                TextColumn::make('juz_id')
                ->sortable()
                ->searchable()
                ->label('Juz Number')
                ->alignCenter(),
                TextColumn::make('words.text')
                ->fontFamily(FontFamily::Serif)
                ->formatStateUsing(function ($record) {
                    // Get all words except the last one
                    $wordsWithoutLast = $record->words->slice(0, -1);

                    // Check if there are words to display
                    if ($wordsWithoutLast->isEmpty()) {
                        return null; // Return null if no words to display
                    }

                    // Join the text from the remaining words and format it
                    return str_replace(',', ' ', $wordsWithoutLast->pluck('text')->implode(' ')); // Combine words' text with a space
                })
                ->limit(100)
                ->size(TextColumnSize::Large)
                ->label('Text')
                ->alignEnd(),
                IconColumn::make('isVerified')
                ->boolean()
                ->trueIcon('heroicon-o-check-circle')
                ->falseIcon('heroicon-o-x-circle')
                ->trueColor('success')
                ->falseColor('danger')
                ->label('Is Verified')
                ->alignCenter(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
