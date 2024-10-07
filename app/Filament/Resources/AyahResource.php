<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AyahResource\Pages;
use App\Filament\Resources\AyahResource\RelationManagers;
use App\Models\Ayah;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AyahResource extends Resource
{
    protected static ?string $model = Ayah::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?int $navigationSort = 40;

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
            TextColumn::make('page_id')
            ->numeric()
            ->sortable()
            ->searchable()
            ->label('Page Id'),
            TextColumn::make('juz_id')
            ->numeric()
            ->sortable()
            ->searchable()
            ->label('Juz Id'),
            ToggleColumn::make('isVerified'),
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
            'index' => Pages\ListAyahs::route('/'),
            // 'create' => Pages\CreateAyah::route('/create'),
            // 'edit' => Pages\EditAyah::route('/{record}/edit'),
        ];
    }
}
