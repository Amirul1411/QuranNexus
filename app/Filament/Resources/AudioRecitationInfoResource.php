<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AudioRecitationInfoResource\RelationManagers\AudioRecitationsRelationManager;
use App\Filament\Resources\AudioRecitationInfoResource\Pages;
use App\Filament\Resources\AudioRecitationInfoResource\RelationManagers;
use App\Models\AudioRecitationInfo;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AudioRecitationInfoResource extends Resource
{
    protected static ?string $model = AudioRecitationInfo::class;

    protected static ?string $pluralModelLabel = 'Audio Recitation Info';

    protected static ?string $navigationIcon = 'heroicon-o-folder';

    protected static ?int $navigationSort = 90;

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('reciter_name')
            ->readOnly()
            ->label('Reciter'),
            Select::make('style')
            ->options(AudioRecitationInfo::STYLES)
            ->disabled()
            ->label('Style'),
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
                TextColumn::make('reciter_name')
                ->searchable()
                ->sortable()
                ->label('Reciter'),
                TextColumn::make('style')
                ->searchable()
                ->sortable()
                ->label('Style')
                ->placeholder('None'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make()
                ])
            ]);
    }

    public static function getRelations(): array
    {
        return [
                AudioRecitationsRelationManager::class,
            ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAudioRecitationInfos::route('/'),
            // 'create' => Pages\CreateAudioRecitationInfo::route('/create'),
            'edit' => Pages\EditAudioRecitationInfo::route('/{record}/edit'),
        ];
    }
}
