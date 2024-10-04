<?php

namespace App\Filament\Resources\ProsesCpmiResource\Widgets;

use App\Models\ProsesCpmi;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ProsesCpmiOverview extends BaseWidget
{
    use InteractsWithPageFilters;

    function generateRandomChartData($count)
    {
        $data = [];
        for ($i = 0; $i < $count; $i++) {
            $data[] = rand(5, 96);
        }
        return $data;
    }

    protected function getStats(): array
    {
        $start = $this->filters['startDate'] ?? null;
        $end = $this->filters['endDate'] ?? null;
        $kantor = $this->filters['kantor'] ?? null; // Ambil filter kantor

        return [
            Stat::make(
                'BARU',
                ProsesCpmi::when($start, fn($query) => $query->whereDate('created_at', '>=', $start))
                    ->when($end, fn($query) => $query->whereDate('created_at', '<=', $end))
                    ->when($kantor, fn($query) => $query->whereHas('pendaftaran', function ($query) use ($kantor) {
                        $query->where('kantor_id', $kantor); // Akses kantor_id dari relasi pendaftaran
                    }))
                    ->where('status_id', 1)
                    ->count()
            )
                ->description('Total CPMI Baru')
                ->descriptionIcon('heroicon-o-check-badge')
                ->color('success')
                ->chart($this->generateRandomChartData(9))
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                    'onclick' => "window.open('/admin/proses-cpmis?tableFilters[Status][values][0]=1')",
                ]),

            Stat::make(
                'PROSES',
                ProsesCpmi::when($start, fn($query) => $query->whereDate('created_at', '>=', $start))
                    ->when($end, fn($query) => $query->whereDate('created_at', '<=', $end))
                    ->when($kantor, fn($query) => $query->whereHas('pendaftaran', function ($query) use ($kantor) {
                        $query->where('kantor_id', $kantor); // Akses kantor_id dari relasi pendaftaran
                    }))
                    ->where('status_id', 2)
                    ->count()
            )
                ->description('Total CPMI On Proses')
                ->descriptionIcon('heroicon-o-check-badge')
                ->color('success')
                ->chart($this->generateRandomChartData(9))
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                    'onclick' => "window.open('/admin/proses-cpmis?tableFilters[Status][values][0]=2')",
                ]),

            Stat::make(
                'TERBANG',
                ProsesCpmi::when($start, fn($query) => $query->whereDate('created_at', '>=', $start))
                    ->when($end, fn($query) => $query->whereDate('created_at', '<=', $end))
                    ->when($kantor, fn($query) => $query->whereHas('pendaftaran', function ($query) use ($kantor) {
                        $query->where('kantor_id', $kantor); // Akses kantor_id dari relasi pendaftaran
                    }))
                    ->where('status_id', 3)
                    ->count()
            )
                ->description('Total CPMI Terbang')
                ->descriptionIcon('heroicon-o-check-badge')
                ->color('success')
                ->chart($this->generateRandomChartData(9))
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                    'onclick' => "window.open('/admin/proses-cpmis?tableFilters[Status][values][0]=3')",
                ]),

            Stat::make(
                'PENDING',
                ProsesCpmi::when($start, fn($query) => $query->whereDate('created_at', '>=', $start))
                    ->when($end, fn($query) => $query->whereDate('created_at', '<=', $end))
                    ->when($kantor, fn($query) => $query->whereHas('pendaftaran', function ($query) use ($kantor) {
                        $query->where('kantor_id', $kantor); // Akses kantor_id dari relasi pendaftaran
                    }))
                    ->where('status_id', 4)
                    ->count()
            )
                ->description('Total CPMI Pending')
                ->descriptionIcon('heroicon-o-check-badge')
                ->color('success')
                ->chart($this->generateRandomChartData(9))
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                    'onclick' => "window.open('/admin/proses-cpmis?tableFilters[Status][values][0]=4')",
                ]),

            Stat::make(
                'UNFIT',
                ProsesCpmi::when($start, fn($query) => $query->whereDate('created_at', '>=', $start))
                    ->when($end, fn($query) => $query->whereDate('created_at', '<=', $end))
                    ->when($kantor, fn($query) => $query->whereHas('pendaftaran', function ($query) use ($kantor) {
                        $query->where('kantor_id', $kantor); // Akses kantor_id dari relasi pendaftaran
                    }))
                    ->where('status_id', 5)
                    ->count()
            )
                ->description('Total CPMI UNFIT')
                ->descriptionIcon('heroicon-o-check-badge')
                ->color('success')
                ->chart($this->generateRandomChartData(9))
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                    'onclick' => "window.open('/admin/proses-cpmis?tableFilters[Status][values][0]=5')",
                ]),

            Stat::make(
                'MD',
                ProsesCpmi::when($start, fn($query) => $query->whereDate('created_at', '>=', $start))
                    ->when($end, fn($query) => $query->whereDate('created_at', '<=', $end))
                    ->when($kantor, fn($query) => $query->whereHas('pendaftaran', function ($query) use ($kantor) {
                        $query->where('kantor_id', $kantor); // Akses kantor_id dari relasi pendaftaran
                    }))
                    ->where('status_id', 6)
                    ->count()
            )
                ->description('Total CPMI Mengundurkan Diri')
                ->descriptionIcon('heroicon-o-check-badge')
                ->color('success')
                ->chart($this->generateRandomChartData(9))
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                    'onclick' => "window.open('/admin/proses-cpmis?tableFilters[Status][values][0]=6')",
                ]),
        ];
    }
}
