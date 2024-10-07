<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JuzResource\Pages;
use App\Filament\Resources\JuzResource\RelationManagers;
use App\Models\Juz;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class JuzResource extends Resource
{
    protected static ?string $model = Juz::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 70;

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
                TextColumn::make('surah.tname')
                ->searchable()
                ->label('Surah Name'),
                TextColumn::make('ayah_index')
                ->numeric()
                ->sortable()
                ->searchable()
                ->label('Ayah Index'),
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
            'index' => Pages\ListJuzs::route('/'),
            // 'create' => Pages\CreateJuz::route('/create'),
            // 'edit' => Pages\EditJuz::route('/{record}/edit'),
        ];
    }
}
