<?php

namespace App\Filament\Resources\TujuanResource\Pages;

use App\Filament\Resources\TujuanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTujuan extends EditRecord
{
    protected static string $resource = TujuanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
