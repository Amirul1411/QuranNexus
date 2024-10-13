<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TafseerInfoResource\Pages;
use App\Filament\Resources\TafseerInfoResource\RelationManagers;
use App\Models\TafseerInfo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TafseerInfoResource extends Resource
{
    protected static ?string $model = TafseerInfo::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListTafseerInfos::route('/'),
            'create' => Pages\CreateTafseerInfo::route('/create'),
            'edit' => Pages\EditTafseerInfo::route('/{record}/edit'),
        ];
    }
}
