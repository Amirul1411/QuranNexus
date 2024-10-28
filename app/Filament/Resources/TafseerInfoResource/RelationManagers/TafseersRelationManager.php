<?php

namespace App\Filament\Resources\TafseerInfoResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Enums\VerticalAlignment;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TafseersRelationManager extends RelationManager
{
    protected static string $relationship = 'tafseers';

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
                RichEditor::make('html')
                ->columnSpanFull()
                ->label('Tafseer Text'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Tafseer')
            ->columns([
                TextColumn::make('surah.tname')
                ->label('Surah Name')
                ->verticalAlignment(VerticalAlignment::Start),
                TextColumn::make('ayah_index')
                ->sortable()
                ->searchable()
                ->label('Ayah Index')
                ->verticalAlignment(VerticalAlignment::Start),
                TextColumn::make('ayah_key')
                ->sortable()
                ->searchable()
                ->label('Ayah Key')
                ->verticalAlignment(VerticalAlignment::Start),
                TextColumn::make('html')
                ->wrap()
                ->html()
                ->label('Tafseer Text'),
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
