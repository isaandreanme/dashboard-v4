<?php

namespace App\Filament\Resources\MarketingResource\Pages;

use App\Filament\Resources\MarketingResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewMarketing extends ViewRecord
{
    protected static string $resource = MarketingResource::class;
    protected static ?string $title = 'LIHAT BIODATA';
    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()->label('Update Biodata'),
        ];
    }

}
