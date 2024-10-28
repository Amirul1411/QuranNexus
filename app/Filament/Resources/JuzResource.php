<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JuzResource\Pages;
use App\Filament\Resources\JuzResource\RelationManagers;
use App\Filament\Resources\JuzResource\RelationManagers\AyahsRelationManager;
use App\Models\Juz;
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

class JuzResource extends Resource
{
    protected static ?string $model = Juz::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document';

    protected static ?int $navigationSort = 70;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('_id')
                ->readOnly()
                ->label('Juz Number'),
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
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('_id')
                ->sortable()
                ->searchable()
                ->label('Juz Number'),
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
            AyahsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListJuzs::route('/'),
            // 'create' => Pages\CreateJuz::route('/create'),
            'edit' => Pages\EditJuz::route('/{record}/edit'),
        ];
    }
}
