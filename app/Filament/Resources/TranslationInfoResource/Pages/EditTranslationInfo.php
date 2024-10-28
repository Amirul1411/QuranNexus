<?php

namespace App\Filament\Resources\TranslationInfoResource\Pages;

use App\Filament\Resources\TranslationInfoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTranslationInfo extends EditRecord
{
    protected static string $resource = TranslationInfoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }
}
