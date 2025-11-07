<?php

namespace App\Filament\Resources\BannedSessionArchiveResource\Pages;

use App\Filament\Resources\BannedSessionArchiveResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBannedSessionArchives extends ListRecords
{
    protected static string $resource = BannedSessionArchiveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
