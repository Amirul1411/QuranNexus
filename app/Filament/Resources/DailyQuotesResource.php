<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DailyQuotesResource\Pages;
use App\Filament\Resources\DailyQuotesResource\RelationManagers;
use App\Models\DailyQuotes;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;

class DailyQuotesResource extends Resource
{
    protected static ?string $model = DailyQuotes::class;

    protected static ?string $navigationIcon = 'heroicon-o-light-bulb';

    protected static ?int $navigationSort = 22;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                ->required()
                ->label('Title'),
                TextInput::make('description')
                ->required()
                ->label('Description'),
                TextInput::make('source')
                ->required()
                ->label('Source'),
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
                TextColumn::make('title')
                ->sortable()
                ->searchable()
                ->alignCenter()
                ->label('Title'),
                TextColumn::make('description')
                ->sortable()
                ->searchable()
                ->label('Description')
                ->alignCenter(),
                TextColumn::make('source')
                ->sortable()
                ->searchable()
                ->alignCenter()
                ->label('Source'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListDailyQuotes::route('/'),
            'create' => Pages\CreateDailyQuotes::route('/create'),
            'edit' => Pages\EditDailyQuotes::route('/{record}/edit'),
        ];
    }
}
