<?php

namespace App\Filament\Resources\TafseerInfoResource\Pages;

use App\Filament\Resources\TafseerInfoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTafseerInfo extends EditRecord
{
    protected static string $resource = TafseerInfoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }
}
