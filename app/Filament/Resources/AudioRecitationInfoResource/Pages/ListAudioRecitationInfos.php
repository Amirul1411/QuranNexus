<?php

namespace App\Filament\Resources\AudioRecitationInfoResource\Pages;

use App\Filament\Resources\AudioRecitationInfoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAudioRecitationInfos extends ListRecords
{
    protected static string $resource = AudioRecitationInfoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
