<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AudioRecitationResource\Pages;
use App\Filament\Resources\AudioRecitationResource\RelationManagers;
use App\Models\AudioRecitation;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AudioRecitationResource extends Resource
{
    protected static ?string $model = AudioRecitation::class;

    protected static ?string $navigationIcon = 'heroicon-o-play-circle';

    protected static ?int $navigationSort = 91;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('audioInfo.reciter_name')
                ->relationship(name: 'audioInfo', titleAttribute: 'reciter_name')
                ->disabled()
                ->label('Reciter'),
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

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('_id')
                ->searchable()
                ->sortable()
                ->label('Id')
                ->alignCenter(),
                TextColumn::make('audioInfo.reciter_name')
                ->label('Reciter'),
                TextColumn::make('surah.tname')
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
            'index' => Pages\ListAudioRecitations::route('/'),
            // 'create' => Pages\CreateAudioRecitation::route('/create'),
            'edit' => Pages\EditAudioRecitation::route('/{record}/edit'),
        ];
    }
}
