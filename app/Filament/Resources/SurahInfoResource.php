<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SurahInfoResource\Pages;
use App\Filament\Resources\SurahInfoResource\RelationManagers;
use App\Models\SurahInfo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SurahInfoResource extends Resource
{
    protected static ?string $model = SurahInfo::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 80;

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
                //
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSurahInfos::route('/'),
            // 'create' => Pages\CreateSurahInfo::route('/create'),
            'edit' => Pages\EditSurahInfo::route('/{record}/edit'),
        ];
    }
}
