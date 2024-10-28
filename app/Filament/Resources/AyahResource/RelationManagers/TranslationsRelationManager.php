<?php

namespace App\Filament\Resources\AyahResource\RelationManagers;

use App\Models\Translation;
use Filament\Forms;
use Filament\Forms\Components\Placeholder;
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

class TranslationsRelationManager extends RelationManager
{
    protected static string $relationship = 'translations';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('translationInfo.translator')
                ->relationship(name: 'translationInfo', titleAttribute: 'translator')
                ->disabled()
                ->label('Translator'),
                Select::make('translationInfo.language')
                ->relationship(name: 'translationInfo', titleAttribute: 'language')
                ->disabled()
                ->label('Language'),
                Textarea::make('text')
                ->columnSpanFull()
                ->rows(5)
                ->readOnly()
                ->label('Translation Text'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Translation')
            ->columns([
                TextColumn::make('translationInfo.translator')
                ->label('Translator'),
                TextColumn::make('translationInfo.language')
                ->label('Language'),
                TextColumn::make('text')
                ->wrap()
                ->label('Translation Text'),
            ])
            ->filters([
                SelectFilter::make('translationInfo')
                ->relationship( 'translationInfo', 'translator', fn (Builder $query) => $query->orderBy('_id'))
                ->label('Translator')
                ->searchable()
                ->preload()
                ->modifyQueryUsing(function (Builder $query, $data) {
                    if (!empty($data['value'])) {
                        $query->where('translation_info_id', $data['value']);
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
