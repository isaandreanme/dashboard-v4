<?php

namespace App\Filament\Resources\MarketingResource\Pages;

use App\Filament\Resources\MarketingResource;
use App\Models\Marketing;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\View\View;

class ListMarketings extends ListRecords
{
    protected static string $resource = MarketingResource::class;
    protected ?string $heading = 'BIODATA MAREKETING';
    protected ?string $subheading = 'List Biodata Marketing';
    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make()
            //     ->icon('heroicon-m-check-badge')
            //     ->label('BIODATA BARU +'),
        ];
    }
    public function getFooter(): ?View
    {
        return view('filament.settings.custom-footer');
    }

    public function getTabs(): array
    {
        return [
            'NON JOB' => Tab::make('NON JOB')
                ->badge(Marketing::query()->where('get_job', '1')->count())
                ->modifyQueryUsing(fn(Builder $query) => $query->where('get_job', '1')),
            'DAPAT JOB' => Tab::make('DAPAT JOB')
                ->badge(Marketing::query()->where('get_job', '0')->count())
                ->modifyQueryUsing(fn(Builder $query) => $query->where('get_job', '0')),
            'ALL BIODATA' => Tab::make('ALL BIODATA')
                ->icon('heroicon-m-clipboard-document-list')
                ->badge(Marketing::query()->count()),
        ];
    }
}
