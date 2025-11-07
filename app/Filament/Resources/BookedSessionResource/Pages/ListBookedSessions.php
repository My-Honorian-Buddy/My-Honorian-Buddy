<?php

namespace App\Filament\Resources\BookedSessionResource\Pages;

use App\Filament\Resources\BookedSessionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBookedSessions extends ListRecords
{
    protected static string $resource = BookedSessionResource::class;

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
