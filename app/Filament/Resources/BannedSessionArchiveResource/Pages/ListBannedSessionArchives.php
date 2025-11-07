<?php

namespace App\Filament\Resources\BannedSessionArchiveResource\Pages;

use App\Filament\Resources\BannedSessionArchiveResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBannedSessionArchives extends ListRecords
{
    protected static string $resource = BannedSessionArchiveResource::class;

    // Enable real-time polling - auto-refresh every 5 seconds
    protected $pollingInterval = '5s';

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
