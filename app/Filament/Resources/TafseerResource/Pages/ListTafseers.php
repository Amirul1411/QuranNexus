<?php

namespace App\Filament\Resources\TafseerResource\Pages;

use App\Filament\Resources\TafseerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTafseers extends ListRecords
{
    protected static string $resource = TafseerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
