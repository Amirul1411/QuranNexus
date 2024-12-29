<?php

namespace App\Filament\Resources\DailyQuotesResource\Pages;

use App\Filament\Resources\DailyQuotesResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDailyQuotes extends CreateRecord
{
    protected static string $resource = DailyQuotesResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['_id'] = (string) getNextSequenceValue('daily_quotes_id');
        return $data;
    }
}
