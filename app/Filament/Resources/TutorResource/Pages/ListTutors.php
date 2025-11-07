<?php

namespace App\Filament\Resources\TutorResource\Pages;

use App\Filament\Resources\TutorResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTutors extends ListRecords
{
    protected static string $resource = TutorResource::class;

    // Enable real-time polling - auto-refresh every 3 seconds
    protected $pollingInterval = '3s';

    public function getPollingInterval(): ?string
    {
        return $this->pollingInterval;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
