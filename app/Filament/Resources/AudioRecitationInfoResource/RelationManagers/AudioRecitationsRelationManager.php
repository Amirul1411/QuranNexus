<?php

namespace App\Filament\Resources\AudioRecitationInfoResource\RelationManagers;

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
                Select::make('surah.tname')
                ->relationship(name: 'surah', titleAttribute: 'tname')
                ->disabled()
                ->label('Surah Name'),
                TextInput::make('ayah_index')
                ->readOnly()
                ->label('Ayah Index'),
                TextInput::make('ayah_key')
                ->readOnly()
                ->label('Ayah Key'),
                TextInput::make('audio_url')
                ->readOnly()
                ->label('Url'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Audio')
            ->columns([
                TextColumn::make('surah.tname')
                ->sortable()
                ->searchable()
                ->label('Surah Name'),
                TextColumn::make('ayah_index')
                ->sortable()
                ->searchable()
                ->label('Ayah Index')
                ->alignCenter(),
                TextColumn::make('ayah_key')
                ->sortable()
                ->searchable()
                ->label('Ayah Key')
                ->alignCenter(),
                TextColumn::make('audio_url')
                ->sortable()
                ->searchable()
                ->label('Url'),
            ])
            ->filters([
                SelectFilter::make('surah')
                ->relationship('surah', 'tname', fn (Builder $query) => $query->orderBy('_id'))
                ->label('Surah Name')
                ->searchable()
                ->preload()
                ->modifyQueryUsing(function (Builder $query, $data) {
                    if (!empty($data['value'])) {
                        $query->where('surah_id', $data['value']);
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
