<?php

namespace App\Filament\Resources\BookedSessionResource\Pages;

use App\Filament\Resources\BookedSessionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBookedSession extends CreateRecord
{
    protected static string $resource = BookedSessionResource::class;
}
