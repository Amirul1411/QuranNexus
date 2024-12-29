<?php

namespace App\Livewire;

use App\Filament\Exports\ChaptersInitialsExporter;
use App\Models\ChaptersInitials as ModelsChaptersInitials;
use App\Models\Surah;
use Livewire\Component;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Enums\FontFamily;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ExportBulkAction;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextColumn\TextColumnSize;

class ChaptersInitials extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(ModelsChaptersInitials::query())
            ->columns([
                TextColumn::make('chapter')
                ->fontFamily(FontFamily::Serif)
                ->size(TextColumnSize::Large)
                ->label('Chapter'),
                TextColumn::make('verse')
                ->label('Verse'),
                TextColumn::make('initials')
                ->fontFamily(FontFamily::Serif)
                ->size(TextColumnSize::Large)
                ->label('Initials'),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                Action::make('View Surah')
                ->button()
                ->outlined()
                ->color('success')
                // ->url(fn (ModelsChaptersInitials $record): string => route('surah.show', ['surah' => substr(explode(':', $record->verse)[0],1)])),
                ->url(fn (ModelsChaptersInitials $record): string => route('surah.show', ['surah' => Surah::where('name', $record->chapter)->first()->id])),
            ])
            ->bulkActions([
                // ExportBulkAction::make()
                // ->exporter(ChaptersInitialsExporter::class)
                // ->columnMapping(false)
            ]);
    }

    public function render()
    {
        return view('livewire.chapters-initials');
    }
}
