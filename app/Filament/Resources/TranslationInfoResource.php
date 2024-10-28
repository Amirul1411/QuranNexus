<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TranslationInfoResource\Pages;
use App\Filament\Resources\TranslationInfoResource\RelationManagers\TranslationsRelationManager;
use App\Models\TranslationInfo;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TranslationInfoResource extends Resource
{
    protected static ?string $model = TranslationInfo::class;

    protected static ?string $pluralModelLabel = 'Translation Info';

    protected static ?string $navigationIcon = 'heroicon-o-folder';

    protected static ?int $navigationSort = 81;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                ->readOnly()
                ->label('Name'),
                TextInput::make('translator')
                ->readOnly()
                ->label('Translator'),
                TextInput::make('language')
                ->readOnly()
                ->label('Language'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('_id')
                ->searchable()
                ->sortable()
                ->label('Id'),
                TextColumn::make('name')
                ->searchable()
                ->sortable()
                ->label('Name'),
                TextColumn::make('translator')
                ->searchable()
                ->sortable()
                ->label('Translator'),
                TextColumn::make('language')
                ->searchable()
                ->sortable()
                ->label('Language'),
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
            TranslationsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTranslationInfos::route('/'),
            // 'create' => Pages\CreateTranslationInfo::route('/create'),
            'edit' => Pages\EditTranslationInfo::route('/{record}/edit'),
        ];
    }
}
