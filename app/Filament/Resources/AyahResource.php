<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AyahResource\Pages;
use App\Filament\Resources\AyahResource\RelationManagers;
use App\Filament\Resources\AyahResource\RelationManagers\AudioRecitationsRelationManager;
use App\Filament\Resources\AyahResource\RelationManagers\TafseerRelationManager;
use App\Filament\Resources\AyahResource\RelationManagers\TranslationsRelationManager;
use App\Filament\Resources\AyahResource\RelationManagers\WordsRelationManager;
use App\Models\Ayah;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontFamily;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AyahResource extends Resource
{
    protected static ?string $model = Ayah::class;

    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';

    protected static ?int $navigationSort = 40;

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
                TextInput::make('ayah_key')
                ->readOnly()
                ->label('Ayah Key'),
                TextInput::make('page_id')
                ->readOnly()
                ->label('Page Number'),
                TextInput::make('juz_id')
                ->readOnly()
                ->label('Juz Number'),
                Toggle::make('isVerified')
                ->required()
                ->label('Is Verified'),
            ]);
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
            TextColumn::make('page_id')
            ->numeric()
            ->sortable()
            ->searchable()
            ->label('Page Number')
            ->alignCenter(),
            TextColumn::make('juz_id')
            ->numeric()
            ->sortable()
            ->searchable()
            ->label('Juz Number')
            ->alignCenter(),
            TextColumn::make('words.text')
            ->fontFamily(FontFamily::Serif)
            ->formatStateUsing(function ($state, $record) {
                // Get all words except the last one
                $wordsWithoutLast = $record->words->slice(0, -1);

                // Check if there are words to display
                if ($wordsWithoutLast->isEmpty()) {
                    return null; // Return null if no words to display
                }

                // Join the text from the remaining words and format it
                return str_replace(',', ' ', $wordsWithoutLast->pluck('text')->implode(' ')); // Combine words' text with a space
            })
            ->limit(100)
            ->size(TextColumnSize::Large)
            ->label('Text')
            ->alignEnd(),
            IconColumn::make('isVerified')
            ->boolean()
            ->trueIcon('heroicon-o-check-circle')
            ->falseIcon('heroicon-o-x-circle')
            ->trueColor('success')
            ->falseColor('danger')
            ->label('Is Verified')
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
            WordsRelationManager::class,
            TranslationsRelationManager::class,
            TafseerRelationManager::class,
            AudioRecitationsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAyahs::route('/'),
            // 'create' => Pages\CreateAyah::route('/create'),
            'edit' => Pages\EditAyah::route('/{record}/edit'),
        ];
    }
}
