<?php

namespace App\Filament\Resources\BannedSessionArchiveResource\Pages;

use App\Filament\Resources\BannedSessionArchiveResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBannedSessionArchives extends ListRecords
{
    protected static string $resource = BannedSessionArchiveResource::class;

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
