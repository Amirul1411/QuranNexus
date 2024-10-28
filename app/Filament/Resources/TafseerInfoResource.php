<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TafseerInfoResource\Pages;
use App\Filament\Resources\TafseerInfoResource\RelationManagers;
use App\Filament\Resources\TafseerInfoResource\RelationManagers\TafseersRelationManager;
use App\Models\TafseerInfo;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TafseerInfoResource extends Resource
{
    protected static ?string $model = TafseerInfo::class;

    protected static ?string $pluralModelLabel = 'Tafseer Info';

    protected static ?string $navigationIcon = 'heroicon-o-folder';

    protected static ?int $navigationSort = 83;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                ->readOnly()
                ->label('Name'),
                TextInput::make('author_name')
                ->readOnly()
                ->label('Author'),
                TextInput::make('language_name')
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
                TextColumn::make('author_name')
                ->searchable()
                ->sortable()
                ->label('Author'),
                TextColumn::make('language_name')
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
            TafseersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTafseerInfos::route('/'),
            // 'create' => Pages\CreateTafseerInfo::route('/create'),
            'edit' => Pages\EditTafseerInfo::route('/{record}/edit'),
        ];
    }
}
