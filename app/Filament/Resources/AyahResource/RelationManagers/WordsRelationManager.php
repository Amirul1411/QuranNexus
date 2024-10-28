<?php

namespace App\Filament\Resources\AyahResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Enums\FontFamily;
use Filament\Tables;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WordsRelationManager extends RelationManager
{
    protected static string $relationship = 'words';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('word_index')
                ->readOnly()
                ->label('Word Index'),
                TextInput::make('word_key')
                ->readOnly()
                ->label('Word Key'),
                TextInput::make('line_number')
                ->readOnly()
                ->label('Line Number'),
                TextInput::make('text')
                ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Word')
            ->columns([
                TextColumn::make('word_index')
                ->sortable()
                ->searchable()
                ->label('Word Index'),
                TextColumn::make('word_key')
                ->sortable()
                ->searchable()
                ->label('Word Key'),
                TextColumn::make('line_number')
                ->sortable()
                ->searchable()
                ->label('Line Number'),
                TextColumn::make('text')
                ->sortable()
                ->searchable()
                ->fontFamily(FontFamily::Serif)
                ->size(TextColumnSize::Large)
                ->label('Text')
                ->alignEnd(),
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
