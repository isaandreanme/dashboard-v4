<?php

namespace App\Filament\Resources\PengalamanResource\Pages;

use App\Filament\Resources\PengalamanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPengalaman extends EditRecord
{
    protected static string $resource = PengalamanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
