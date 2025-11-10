<?php

namespace App\Filament\Resources\TutorResource\Pages;

use App\Filament\Resources\TutorResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTutors extends ListRecords
{
    protected static string $resource = TutorResource::class;

    /**
     * Refresh the page every 5 seconds to show real-time updates
     */
    protected static ?string $pollingInterval = '5s';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
