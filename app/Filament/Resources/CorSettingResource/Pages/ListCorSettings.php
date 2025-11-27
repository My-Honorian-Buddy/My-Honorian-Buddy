<?php

namespace App\Filament\Resources\CorSettingResource\Pages;

use App\Filament\Resources\CorSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCorSettings extends ListRecords
{
    protected static string $resource = CorSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
