<?php

namespace App\Filament\Resources\AudioRecitationInfoResource\Pages;

use App\Filament\Resources\AudioRecitationInfoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAudioRecitationInfo extends EditRecord
{
    protected static string $resource = AudioRecitationInfoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
