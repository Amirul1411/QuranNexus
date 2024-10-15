<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AudioRecitationResource\Pages;
use App\Filament\Resources\AudioRecitationResource\RelationManagers;
use App\Models\AudioRecitation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AudioRecitationResource extends Resource
{
    protected static ?string $model = AudioRecitation::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 91;

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
            'index' => Pages\ListAudioRecitations::route('/'),
            'create' => Pages\CreateAudioRecitation::route('/create'),
            'edit' => Pages\EditAudioRecitation::route('/{record}/edit'),
        ];
    }
}
