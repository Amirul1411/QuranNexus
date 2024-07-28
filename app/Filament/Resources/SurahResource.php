<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SurahResource\Pages;
use App\Filament\Resources\SurahResource\RelationManagers;
use App\Filament\Resources\SurahResource\RelationManagers\AyahRelationManager;
use App\Models\Surah;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SurahResource extends Resource
{
    protected static ?string $model = Surah::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            TextInput::make('name')
                ->required(),
            TextInput::make('ename')
                ->required(),
            TextInput::make('tname')
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('_id')
                ->sortable()
                ->label('Id'),
                TextColumn::make('name')
                ->sortable()
                ->searchable()
                ->label('Arabic Name'),
                TextColumn::make('tname')
                ->sortable()
                ->searchable()
                ->label('Name'),
                TextColumn::make('ename')
                ->sortable()
                ->searchable()
                ->label('Name Meaning'),
                TextColumn::make('ayas')
                ->sortable()
                ->searchable()
                ->label('Number of ayahs'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            AyahRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSurahs::route('/'),
            'create' => Pages\CreateSurah::route('/create'),
            'edit' => Pages\EditSurah::route('/{record}/edit'),
        ];
    }
}
