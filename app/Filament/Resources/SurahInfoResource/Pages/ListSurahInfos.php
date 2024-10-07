<?php

namespace App\Filament\Resources\SurahInfoResource\Pages;

use App\Filament\Resources\SurahInfoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSurahInfos extends ListRecords
{
    protected static string $resource = SurahInfoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
