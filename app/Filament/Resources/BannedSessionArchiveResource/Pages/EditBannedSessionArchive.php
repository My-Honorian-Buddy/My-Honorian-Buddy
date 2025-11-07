<?php

namespace App\Filament\Resources\BannedSessionArchiveResource\Pages;

use App\Filament\Resources\BannedSessionArchiveResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBannedSessionArchive extends EditRecord
{
    protected static string $resource = BannedSessionArchiveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
