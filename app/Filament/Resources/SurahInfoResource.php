<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SurahInfoResource\Pages;
use App\Filament\Resources\SurahInfoResource\RelationManagers;
use App\Models\SurahInfo;
use Filament\Forms;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SurahInfoResource extends Resource
{
    protected static ?string $model = SurahInfo::class;

    protected static ?string $pluralModelLabel = 'Surah Info';

    protected static ?string $navigationIcon = 'heroicon-o-folder';

    protected static ?int $navigationSort = 31;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Placeholder::make('surah.tname')
            ->label('Surah Name')
            ->content(fn (SurahInfo $record): string => $record->surah->tname),
            Placeholder::make('surah.ayas')
            ->label('Number of Ayah')
            ->content(fn (SurahInfo $record): string => $record->surah->ayas),
            Placeholder::make('surah.type')
            ->label('Type')
            ->content(fn (SurahInfo $record): string => $record->surah->type),
            RichEditor::make('html')
            ->label('Surah Info')
            ->columnSpanFull()]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('_id')
                ->sortable()
                ->searchable()
                ->label('Id')
                ->alignCenter(),
                TextColumn::make('surah.tname')
                ->searchable()
                ->label('Surah Name'),
                TextColumn::make('html')
                ->limit(100)
                ->label('Surah Info'),
            ])
            ->filters([
                SelectFilter::make('surah')
                ->relationship('surah', 'tname', fn (Builder $query) => $query->orderBy('_id'))
                ->label('Surah Name')
                ->searchable()
                ->preload()
                ->modifyQueryUsing(function (Builder $query, $data) {
                    if (!empty($data['value'])) {
                        $query->where('_id', $data['value']);
                    }
                }),
            ])
            ->actions([Tables\Actions\EditAction::make()])
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
            'index' => Pages\ListSurahInfos::route('/'),
            // 'create' => Pages\CreateSurahInfo::route('/create'),
            'edit' => Pages\EditSurahInfo::route('/{record}/edit'),
        ];
    }
}
