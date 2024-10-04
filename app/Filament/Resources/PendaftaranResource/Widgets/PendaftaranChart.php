<?php

namespace App\Filament\Resources\PendaftaranResource\Widgets;

use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;
use App\Models\Pendaftaran;
use App\Models\ProsesCpmi;
use App\Models\Kantor;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Carbon;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class PendaftaranChart extends ApexChartWidget
{
    use InteractsWithPageFilters; // Mengaktifkan filter halaman

    /**
     * Chart Id
     *
     * @var string
     */
    protected static ?string $chartId = 'blogPostsChart';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'PENDAFTARAN';
    protected int | string | array $columnSpan = 'full';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {
        // Mengakses filter dari halaman (misalnya, startDate dan endDate)
        $start = $this->filters['startDate'] ?? null;
        $end = $this->filters['endDate'] ?? null;

        $kantor1Nama = Kantor::find(1)->nama ?? 'Kantor 1';
        $kantor2Nama = Kantor::find(2)->nama ?? 'Kantor 2';
        $kantor3Nama = Kantor::find(3)->nama ?? 'Kantor 3';
        $kantor4Nama = Kantor::find(4)->nama ?? 'Kantor 4';

        $data = Trend::model(ProsesCpmi::class)
            ->between(
                start: $start ? Carbon::parse($start) : now()->subMonths(6),
                end: $end ? Carbon::parse($end) : now()
            )
            ->perMonth()
            ->count();

        $kantor1 = $this->getKantorData(1, $start, $end);
        $kantor2 = $this->getKantorData(2, $start, $end);
        $kantor3 = $this->getKantorData(3, $start, $end);
        $kantor4 = $this->getKantorData(4, $start, $end);

        return [
            'chart' => [
                'type' => 'line',
                'height' => 300,
            ],
            'series' => [
                [
                    'name' => $kantor1Nama,
                    'data' => $kantor1->map(fn(TrendValue $value) => $value->aggregate),
                ],
                [
                    'name' => $kantor2Nama,
                    'data' => $kantor2->map(fn(TrendValue $value) => $value->aggregate),
                ],
                [
                    'name' => $kantor3Nama,
                    'data' => $kantor3->map(fn(TrendValue $value) => $value->aggregate),
                ],
                [
                    'name' => $kantor4Nama,
                    'data' => $kantor4->map(fn(TrendValue $value) => $value->aggregate),
                ],
                [
                    'name' => 'TOTAL',
                    'data' => $data->map(fn(TrendValue $value) => $value->aggregate),
                ],
            ],
            'xaxis' => [
                'categories' => $data->map(fn(TrendValue $value) => Carbon::parse($value->date)->translatedFormat('M y')),
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'yaxis' => [
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'colors' => ['#f59e0b', '#1c64f2', '#10b981', '#ef4444', '#6b7280'],
            'stroke' => [
                'curve' => 'smooth',
                'width' => 2, // Mengatur ketebalan garis menjadi 2 (nilai ini bisa disesuaikan)
            ],

            // Grid-----------------------------------
            'grid' => [
                'show' => false,
                'borderColor' => '#e0e0e0',  // Mengatur warna grid line (lebih terang)
                'strokeDashArray' => 1,       // Membuat grid line menjadi dashed
                'xaxis' => [
                    'lines' => [
                        'show' => true,      // Tampilkan grid pada x-axis
                    ],
                ],
                'yaxis' => [
                    'lines' => [
                        'show' => true,      // Tampilkan grid pada y-axis
                    ],
                ],
            ],
            // Grid-----------------------------------

        ];
    }

    private function getKantorData(int $kantorId, $start, $end)
    {
        $query = Pendaftaran::query()->where('kantor_id', $kantorId);
        return Trend::query($query)
            ->dateColumn('created_at')
            ->between(
                start: $start ? Carbon::parse($start) : now()->subMonths(6),
                end: $end ? Carbon::parse($end) : now()
            )
            ->perMonth()
            ->count();
    }
}
