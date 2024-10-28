<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InquiryResource\Pages;
use App\Filament\Resources\InquiryResource\RelationManagers;
use App\Models\Inquiry;
use Filament\Forms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InquiryResource extends Resource
{
    protected static ?string $model = Inquiry::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-oval-left-ellipsis';

    protected static ?int $navigationSort = 20;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('first_name')
                ->readOnly()
                ->label('First Name'),
                TextInput::make('last_name')
                ->readOnly()
                ->label('Last Name'),
                TextInput::make('phone')
                ->readOnly()
                ->label('Phone Number'),
                TextInput::make('email')
                ->readOnly()
                ->label('Email'),
                Textarea::make('message')
                ->readOnly()
                ->columnSpanFull()
                ->rows(10)
                ->label('Message'),
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
                TextColumn::make('first_name')
                ->sortable()
                ->searchable()
                ->label('First Name')
                ->alignCenter(),
                TextColumn::make('last_name')
                ->sortable()
                ->searchable()
                ->label('Last Name')
                ->alignCenter(),
                TextColumn::make('phone')
                ->sortable()
                ->searchable()
                ->label('Phone'),
                TextColumn::make('email')
                ->sortable()
                ->searchable()
                ->label('Email'),
                TextColumn::make('message')
                ->wrap()
                ->label('Message'),
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
            'index' => Pages\ListInquiries::route('/'),
            // 'create' => Pages\CreateInquiry::route('/create'),
            'edit' => Pages\EditInquiry::route('/{record}/edit'),
        ];
    }
}
