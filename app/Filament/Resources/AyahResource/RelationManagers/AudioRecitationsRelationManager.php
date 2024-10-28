<?php

namespace App\Filament\Resources\AyahResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AudioRecitationsRelationManager extends RelationManager
{
    protected static string $relationship = 'audioRecitations';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('audioInfo.reciter_name')
                ->relationship(name: 'audioInfo', titleAttribute: 'reciter_name')
                ->disabled()
                ->label('Reciter'),
                TextInput::make('audio_url')
                ->readOnly()
                ->label('Url'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('audioRecitation')
            ->columns([
                TextColumn::make('audioInfo.reciter_name')
                ->label('Reciter'),
                TextColumn::make('audio_url')
                ->sortable()
                ->searchable()
                ->label('Url'),
            ])
            ->filters([
                SelectFilter::make('audioInfo')
                ->relationship('audioInfo', 'reciter_name', fn (Builder $query) => $query->orderBy('_id'))
                ->label('Reciter')
                ->searchable()
                ->preload()
                ->modifyQueryUsing(function (Builder $query, $data) {
                    if (!empty($data['value'])) {
                        $query->where('audio_info_id', $data['value']);
                    }
                }),
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
