<?php

namespace App\Filament\Resources\AudioRecitationResource\Pages;

use App\Filament\Resources\AudioRecitationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAudioRecitations extends ListRecords
{
    protected static string $resource = AudioRecitationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
