<?php

namespace App\Filament\Resources\AyahResource\RelationManagers;

use App\Models\Tafseer;
use Filament\Forms;
use Filament\Forms\Components\Placeholder;
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
use Illuminate\Support\HtmlString;

class TafseerRelationManager extends RelationManager
{
    protected static string $relationship = 'tafseer';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('tafseerInfo.name')
                ->relationship(name: 'tafseerInfo', titleAttribute: 'name')
                ->disabled()
                ->label('Name'),
                Select::make('tafseerInfo.author_name')
                ->relationship(name: 'tafseerInfo', titleAttribute: 'author_name')
                ->disabled()
                ->label('Author'),
                RichEditor::make('html')
                ->label('Tafseer Text')
                ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Tafseer')
            ->columns([
                TextColumn::make('tafseerInfo.name')
                ->verticalAlignment(VerticalAlignment::Start)
                ->label('Name'),
                TextColumn::make('tafseerInfo.author_name')
                ->verticalAlignment(VerticalAlignment::Start)
                ->label('Author'),
                TextColumn::make('html')
                ->html()
                ->wrap()
                ->label('Tafseer'),
            ])
            ->filters([
                SelectFilter::make('tafseerInfo')
                ->relationship('tafseerInfo', 'name', fn (Builder $query) => $query->orderBy('_id'))
                ->label('Tafseer Name')
                ->searchable()
                ->preload()
                ->modifyQueryUsing(function (Builder $query, $data) {
                    if (!empty($data['value'])) {
                        $query->where('tafseer_info_id', $data['value']);
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
