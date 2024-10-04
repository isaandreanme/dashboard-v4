<?php

namespace App\Filament\Resources\PendaftaranResource\Widgets;

use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;
use App\Models\ProsesCpmi;
use App\Models\Kantor;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Carbon;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class IDChart extends ApexChartWidget
{
    use InteractsWithPageFilters;

    protected static ?string $chartId = 'idBp2miChart';
    protected static ?string $heading = 'ID BP2MI';
    // protected int | string | array $columnSpan = 'full';

    /**
     * Mengambil data untuk grafik
     *
     * @return array
     */
    protected function getOptions(): array
    {
        // Mengakses filter tanggal dari halaman
        $start = $this->filters['startDate'] ?? null;
        $end = $this->filters['endDate'] ?? null;

        // Ambil nama kantor dari model Kantor
        $kantor1Nama = Kantor::find(1)->nama ?? 'Kantor 1';
        $kantor2Nama = Kantor::find(2)->nama ?? 'Kantor 2';
        $kantor3Nama = Kantor::find(3)->nama ?? 'Kantor 3';
        $kantor4Nama = Kantor::find(4)->nama ?? 'Kantor 4';

        // Ambil data per bulan untuk tiap kantor
        $kantor1 = $this->getKantorData(1, $start, $end);
        $kantor2 = $this->getKantorData(2, $start, $end);
        $kantor3 = $this->getKantorData(3, $start, $end);
        $kantor4 = $this->getKantorData(4, $start, $end);

        // Ambil data total tanpa filter kantor_id
        $total = $this->getTotalData($start, $end);

        return [
            'chart' => [
                'type' => 'line', // Jenis grafik garis
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
                    'data' => $total->map(fn(TrendValue $value) => $value->aggregate),
                ],
            ],
            'xaxis' => [
                'categories' => $total->map(fn(TrendValue $value) => Carbon::parse($value->date)->translatedFormat('M y')),
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
            'colors' => ['#f59e0b', '#1c64f2', '#10b981', '#ef4444', '#6b7280'], // Warna per kantor
            'stroke' => [
                'curve' => 'smooth', // Garis halus
                'width' => 2, // Ketebalan garis
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

    /**
     * Fungsi untuk mengambil data per kantor
     */
    private function getKantorData(int $kantorId, $start, $end)
    {
        $query = ProsesCpmi::query()
            ->join('pendaftarans', 'proses_cpmis.pendaftaran_id', '=', 'pendaftarans.id')
            ->where('pendaftarans.kantor_id', $kantorId);
        return Trend::query($query)
            ->dateColumn('proses_cpmis.tgl_bp2mi')
            ->between(
                start: $start ? Carbon::parse($start) : now()->subMonths(6),
                end: $end ? Carbon::parse($end) : now()
            )
            ->perMonth()
            ->count();
    }

    /**
     * Fungsi untuk mengambil data total tanpa filter kantor
     */
    private function getTotalData($start, $end)
    {
        $query = ProsesCpmi::query()
            ->join('pendaftarans', 'proses_cpmis.pendaftaran_id', '=', 'pendaftarans.id');
        return Trend::query($query)
            ->dateColumn('proses_cpmis.tgl_bp2mi')
            ->between(
                start: $start ? Carbon::parse($start) : now()->subMonths(6),
                end: $end ? Carbon::parse($end) : now()
            )
            ->perMonth()
            ->count();
    }
}
