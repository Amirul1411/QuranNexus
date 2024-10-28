<?php

namespace App\Filament\Resources\TafseerInfoResource\Pages;

use App\Filament\Resources\TafseerInfoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTafseerInfos extends ListRecords
{
    protected static string $resource = TafseerInfoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
