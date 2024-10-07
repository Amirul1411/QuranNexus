<?php

namespace App\Filament\Resources\TafseerResource\Pages;

use App\Filament\Resources\TafseerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTafseer extends EditRecord
{
    protected static string $resource = TafseerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
