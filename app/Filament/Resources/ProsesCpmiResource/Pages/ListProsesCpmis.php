<?php

namespace App\Filament\Resources\ProsesCpmiResource\Pages;

use App\Filament\Resources\ProsesCpmiResource;
use App\Models\ProsesCpmi;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\View\View;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListProsesCpmis extends ListRecords
{
    protected static string $resource = ProsesCpmiResource::class;
    protected ?string $heading = 'PROSES CPMI';
    protected ?string $subheading = 'List Proses CPMI';
    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make()
            //     ->icon('heroicon-m-check-badge')
            //     ->label('PROSES CPMI BARU +'),
        ];
    }
    public function getFooter(): ?View
    {
        return view('filament.settings.custom-footer');
    }
    public function getTabs(): array
    {
        return [
            'ALL' => Tab::make('ALL PROSES')
                ->icon('heroicon-o-arrow-path-rounded-square')
                ->badge(ProsesCpmi::query()->count()),
            'BARU' => Tab::make('BARU')
                ->badge(ProsesCpmi::query()->where('status_id', '1')->count())
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status_id', '1')),
            'ON PROSES' => Tab::make('ON PROSES')
                ->badge(ProsesCpmi::query()->where('status_id', '2')->count())
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status_id', '2')),
            'TERBANG' => Tab::make('TERBANG')
                ->badge(ProsesCpmi::query()->where('status_id', '3')->count())
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status_id', '3')),
            'PENDING' => Tab::make('PENDING')
                ->badge(ProsesCpmi::query()->where('status_id', '4')->count())
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status_id', '4')),
            'UNFIT' => Tab::make('UNFIT')
                ->badge(ProsesCpmi::query()->where('status_id', '5')->count())
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status_id', '5')),
            'MD' => Tab::make('MD')
                ->badge(ProsesCpmi::query()->where('status_id', '6')->count())
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status_id', '6')),

        ];
    }
}
