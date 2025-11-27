<?php

namespace App\Filament\Resources\CorSettingResource\Pages;

use App\Filament\Resources\CorSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCorSetting extends EditRecord
{
    protected static string $resource = CorSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
