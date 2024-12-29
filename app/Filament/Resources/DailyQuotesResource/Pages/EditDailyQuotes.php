<?php

namespace App\Filament\Resources\DailyQuotesResource\Pages;

use App\Filament\Resources\DailyQuotesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDailyQuotes extends EditRecord
{
    protected static string $resource = DailyQuotesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
