<?php

namespace App\Filament\Resources\AchievementResource\Pages;

use App\Filament\Resources\AchievementResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAchievement extends CreateRecord
{
    protected static string $resource = AchievementResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['_id'] = (string) getNextSequenceValue('achievement_id');
        return $data;
    }

}
