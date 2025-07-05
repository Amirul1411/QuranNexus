<?php

namespace App\Filament\Exports;

use App\Models\ChaptersInitials;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class ChaptersInitialsExporter extends Exporter
{
    protected static ?string $model = ChaptersInitials::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('_id')
            ->label('Id'),
            ExportColumn::make('surah.name')
            ->label('Chapter'),
            ExportColumn::make('ayah_key')
            ->label('Verse Key'),
            ExportColumn::make('initials')
            ->label('Initials'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your chapters initials export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
