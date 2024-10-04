<?php

namespace App\Filament\Resources\TujuanResource\Pages;

use App\Filament\Resources\TujuanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTujuans extends ListRecords
{
    protected static string $resource = TujuanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
