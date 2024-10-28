<?php

namespace App\Filament\Resources\SurahResource\RelationManagers;

use App\Models\SurahInfo;
use Filament\Forms;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SurahInfoRelationManager extends RelationManager
{
    protected static string $relationship = 'surahInfo';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Placeholder::make('surah.tname')
                ->label('Surah Name')
                ->content(fn (SurahInfo $record): string => $record->surah->tname),
                Placeholder::make('surah.ayas')
                ->label('Number of Ayah')
                ->content(fn (SurahInfo $record): string => $record->surah->ayas),
                Placeholder::make('surah.type')
                ->label('Type')
                ->content(fn (SurahInfo $record): string => $record->surah->type),
                RichEditor::make('html')
                ->columnSpanFull()
                ->label('Surah Info'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Surah Info')
            ->columns([
                TextColumn::make('html')
                ->html()
                ->wrap()
                ->label('Surah Info'),
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
