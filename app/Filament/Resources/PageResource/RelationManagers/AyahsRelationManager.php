<?php

namespace App\Filament\Resources\PageResource\RelationManagers;

use App\Models\Word;
use Filament\Forms;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Enums\FontFamily;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AyahsRelationManager extends RelationManager
{
    protected static string $relationship = 'ayahs';

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
                TextInput::make('juz_id')
                ->readOnly()
                ->label('Juz Number'),
                Repeater::make('words')
                ->relationship()
                ->schema([
                    Placeholder::make('word_key')
                    ->label('Word Key')
                    ->content(fn (Word $record): string => $record->word_key),
                    TextInput::make('text')
                    ->required(),
                ])
                ->columnSpanFull()
                ->addable(false)
                ->deletable(false),
                Toggle::make('isVerified')
                ->label('Is Verified'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Ayah')
            ->columns([
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
                TextColumn::make('juz_id')
                ->sortable()
                ->searchable()
                ->label('Juz Number')
                ->alignCenter(),
                TextColumn::make('words.text')
                ->fontFamily(FontFamily::Serif)
                ->formatStateUsing(fn (string $state): string => str_replace(',', ' ', $state))
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
