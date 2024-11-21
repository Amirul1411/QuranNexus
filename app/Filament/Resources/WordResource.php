<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WordResource\Pages;
use App\Filament\Resources\WordResource\RelationManagers;
use App\Models\Ayah;
use App\Models\Surah;
use App\Models\Word;
use Filament\Forms;
use Filament\Forms\Components\Placeholder;
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
use MongoDB\Laravel\Eloquent\Model;

class WordResource extends Resource
{
    protected static ?string $model = Word::class;

    protected static ?string $navigationIcon = 'heroicon-o-bold';

    protected static ?int $navigationSort = 50;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('surah.tname')
                ->relationship(name: 'surah', titleAttribute: 'tname')
                ->label('Surah Name')
                ->disabled(),
                TextInput::make('ayah_index')
                ->readOnly()
                ->label('Ayah Index'),
                TextInput::make('word_index')
                ->readOnly()
                ->label('Word Index'),
                TextInput::make('word_key')
                ->readOnly()
                ->label('Word Key'),
                TextInput::make('audio_url')
                ->readOnly()
                ->label('Audio Url'),
                TextInput::make('page_id')
                ->readOnly()
                ->label('Page Number'),
                TextInput::make('line_number')
                ->readOnly()
                ->label('Line Number'),
                TextInput::make('text')
                ->required()
                ->label('Word Text'),
                TextInput::make('translation')
                ->readOnly()
                ->label('Translation'),
                TextInput::make('transliteration')
                ->readOnly()
                ->label('Transliteration'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->modifyQueryUsing( fn (Builder $query) => $query->whereNotNull('audio_url'))
        ->columns([
            TextColumn::make('_id')
            ->numeric()
            ->sortable()
            ->searchable()
            ->label('Id')
            ->alignCenter(),
            TextColumn::make('surah.tname')
            ->label('Surah Name'),
            TextColumn::make('ayah_index')
            ->numeric()
            ->sortable()
            ->searchable()
            ->label('Ayah Index')
            ->alignCenter(),
            TextColumn::make('word_index')
            ->numeric()
            ->sortable()
            ->searchable()
            ->label('Word Index')
            ->alignCenter(),
            TextColumn::make('word_key')
            ->sortable()
            ->searchable()
            ->label('Word Key')
            ->alignCenter(),
            TextColumn::make('audio_url')
            ->sortable()
            ->searchable()
            ->label('Audio Url')
            ->placeholder('N/A'),
            TextColumn::make('page_id')
            ->sortable()
            ->searchable()
            ->label('Page Number')
            ->alignCenter(),
            TextColumn::make('line_number')
            ->sortable()
            ->searchable()
            ->label('Line Number')
            ->alignCenter(),
            TextColumn::make('text')
            ->label('Word Text')
            ->sortable()
            ->searchable()
            ->alignEnd(),
            TextColumn::make('translation')
            ->sortable()
            ->searchable()
            ->label('Translation'),
            TextColumn::make('transliteration')
            ->sortable()
            ->searchable()
            ->label('Transliteration')
            ->placeholder('N/A'),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWords::route('/'),
            // 'create' => Pages\CreateWord::route('/create'),
            'edit' => Pages\EditWord::route('/{record}/edit'),
        ];
    }
}
