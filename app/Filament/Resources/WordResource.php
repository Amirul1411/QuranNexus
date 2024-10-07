<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WordResource\Pages;
use App\Filament\Resources\WordResource\RelationManagers;
use App\Models\Word;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WordResource extends Resource
{
    protected static ?string $model = Word::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 50;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            TextColumn::make('_id')
            ->numeric()
            ->sortable()
            ->searchable()
            ->label('Id'),
            TextColumn::make('ayah.surah.tname')
            ->searchable()
            ->label('Surah Name'),
            TextColumn::make('ayah_index')
            ->numeric()
            ->sortable()
            ->searchable()
            ->label('Ayah Index'),
            TextColumn::make('word_index')
            ->numeric()
            ->sortable()
            ->searchable()
            ->label('Word Index'),
            TextColumn::make('ayah.page_id')
            ->numeric()
            ->sortable()
            ->searchable()
            ->label('Page Number'),
            TextColumn::make('line_number')
            ->numeric()
            ->sortable()
            ->searchable()
            ->label('Line Number'),
            TextColumn::make('text')
            ->label('Word Text'),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWords::route('/'),
            // 'create' => Pages\CreateWord::route('/create'),
            // 'edit' => Pages\EditWord::route('/{record}/edit'),
        ];
    }
}
