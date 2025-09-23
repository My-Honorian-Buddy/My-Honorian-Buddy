<?php

namespace App\Filament\Resources\TutorResource\Pages;

use App\Filament\Resources\TutorResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;

class EditTutor extends EditRecord
{
    protected static string $resource = TutorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
