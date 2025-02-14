<?php

namespace App\Filament\Resources\DailyQuotesResource\Pages;

use App\Filament\Resources\DailyQuotesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDailyQuotes extends ListRecords
{
    protected static string $resource = DailyQuotesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
