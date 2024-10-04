<?php

namespace App\Filament\Resources\PendaftaranResource\Pages;

use App\Filament\Resources\PendaftaranResource;
use App\Models\Pendaftaran;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\View\View;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;


class ListPendaftarans extends ListRecords
{
    protected static string $resource = PendaftaranResource::class;
    protected ?string $heading = 'PENDAFTARAN';
    protected ?string $subheading = 'List Pendaftaran';
    
    public function getFooter(): ?View
    {
        return view('filament.settings.custom-footer');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->icon('heroicon-m-check-badge')
                ->label('PENDAFTARAN BARU +'),
        ];
    }
    public function getTabs(): array
    {
        return [
            'ALL' => Tab::make('DOCUMENT')
                ->icon('heroicon-m-clipboard-document-list')
                ->badge(Pendaftaran::query()->count()),
            'LENGKAP' => Tab::make('LENGKAP')
                ->badge(Pendaftaran::query()->where('data_lengkap', '1')->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('data_lengkap', '1')),
            'TIDAK' => Tab::make('TIDAK')
                ->badge(Pendaftaran::query()->where('data_lengkap', '0')->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('data_lengkap', '0')),
        ];
    }
}
