<?php

namespace App\Filament\Resources\JuzResource\Pages;

use App\Filament\Resources\JuzResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJuz extends EditRecord
{
    protected static string $resource = JuzResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
