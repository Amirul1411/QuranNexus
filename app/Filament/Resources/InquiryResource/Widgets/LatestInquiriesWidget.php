<?php

namespace App\Filament\Resources\InquiryResource\Widgets;

use App\Filament\Resources\InquiryResource;
use App\Models\Inquiry;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Widgets\TableWidget as BaseWidget;
use PhpParser\Node\Stmt\Label;

class LatestInquiriesWidget extends BaseWidget
{

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Inquiry::whereDate('created_at', '>', now()->subDays(5)->startOfDay())->orderBy('created_at', 'desc')
            )
            ->columns([
                TextColumn::make('first_name')
                ->label('First Name')
                ->alignCenter(),
                TextColumn::make('last_name')
                ->label('Last Name')
                ->alignCenter(),
                TextColumn::make('message')
                ->wrap(),
                TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->alignCenter(),
            ]);
    }
}
