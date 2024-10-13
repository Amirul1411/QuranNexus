<?php

namespace App\Filament\Resources\TranslationInfoResource\Pages;

use App\Filament\Resources\TranslationInfoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTranslationInfos extends ListRecords
{
    protected static string $resource = TranslationInfoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
