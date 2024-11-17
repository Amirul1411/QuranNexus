<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TafseerResource\Pages;
use App\Filament\Resources\TafseerResource\RelationManagers;
use App\Models\Tafseer;
use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
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

class TafseerResource extends Resource
{
    protected static ?string $model = Tafseer::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?int $navigationSort = 84;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('tafseerInfo.name')
                ->relationship(name: 'tafseerInfo', titleAttribute: 'name')
                ->disabled()
                ->label('Tafseer Name'),
                Select::make('tafseerInfo.author_name')
                ->relationship(name: 'tafseerInfo', titleAttribute: 'author_name')
                ->disabled()
                ->label('Author'),
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

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('_id')
                ->searchable()
                ->sortable()
                ->label('Id')
                ->alignCenter(),
                TextColumn::make('tafseerInfo.name')
                ->label('Tafseer Name'),
                TextColumn::make('tafseerInfo.author_name')
                ->label('Author'),
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
                TextColumn::make('html')
                ->wrap()
                ->html()
                ->limit(100)
                ->label('Tafseer Text')
                ->placeholder('None'),
            ])
            ->filters([
                SelectFilter::make('tafseerInfo')
                ->relationship('tafseerInfo', 'name', fn (Builder $query) => $query->orderBy('_id'))
                ->searchable()
                ->preload()
                ->modifyQueryUsing(function (Builder $query, $data) {
                    if (!empty($data['value'])) {
                        $query->where('tafseer_info_id', $data['value']);
                    }
                })
                ->label('Tafseer Name'),
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
            'index' => Pages\ListTafseers::route('/'),
            // 'create' => Pages\CreateTafseer::route('/create'),
            'edit' => Pages\EditTafseer::route('/{record}/edit'),
        ];
    }
}
