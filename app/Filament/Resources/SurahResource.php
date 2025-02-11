<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SurahResource\Pages;
use App\Filament\Resources\SurahResource\RelationManagers;
use App\Filament\Resources\SurahResource\RelationManagers\AyahRelationManager;
use App\Filament\Resources\SurahResource\RelationManagers\SurahInfoRelationManager;
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
use Filament\Forms\Components\Select;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;
use MongoDB\Laravel\Eloquent\Builder as EloquentBuilder;

class SurahResource extends Resource
{
    protected static ?string $model = Surah::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?int $navigationSort = 30;

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')
            ->readOnly()
            ->label('Arabic Name'),
            TextInput::make('ename')
            ->readOnly()
            ->label('Name Meaning'),
            TextInput::make('tname')
            ->readOnly()
            ->label('Name'),
            TextInput::make('ayas')
            ->readOnly()
            ->label('Number of Ayahs'),
            TextInput::make('word_count')
            ->readOnly()
            ->label('Number of Words'),
            Select::make('type')
            ->options(Surah::TYPES)
            ->label('Role')
            ->disabled(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('_id')
                ->sortable()
                ->searchable()
                ->label('Id')
                ->alignCenter(),
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
                TextColumn::make('type')
                ->sortable()
                ->label('Type')
                ->badge()
                ->color(
                    fn(string $state): string => match ($state) {
                        'Meccan' => 'info',
                        'Medinan' => 'success',
                    },
                )
                ->alignCenter(),
                TextColumn::make('ayas')
                ->sortable()
                ->label('Number of Ayahs')
                ->alignCenter(),
                TextColumn::make('word_count')
                ->sortable()
                ->label('Number of Words')
                ->alignCenter(),
            ])
            ->filters([
                //
            ])
            ->actions([Tables\Actions\EditAction::make()])
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
            SurahInfoRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSurahs::route('/'),
            // 'create' => Pages\CreateSurah::route('/create'),
            'edit' => Pages\EditSurah::route('/{record}/edit'),
        ];
    }
}
