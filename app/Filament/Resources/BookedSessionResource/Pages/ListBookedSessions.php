<?php

namespace App\Filament\Resources\BookedSessionResource\Pages;

use App\Filament\Resources\BookedSessionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBookedSessions extends ListRecords
{
    protected static string $resource = BookedSessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
