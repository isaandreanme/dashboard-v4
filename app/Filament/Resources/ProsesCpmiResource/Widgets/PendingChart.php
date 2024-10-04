<?php

namespace App\Filament\Resources\ProsesCpmiResource\Widgets;

use App\Models\ProsesCpmi;
use App\Models\Kantor; // Import model Kantor
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class PendingChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected static ?string $heading = 'PENDING';
    protected static ?string $maxHeight = '200px';
    // protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        // Mengambil filter startDate dan endDate dari halaman menggunakan InteractsWithPageFilters
        $start = $this->filters['startDate'] ?? null;
        $end = $this->filters['endDate'] ?? null;

        // Mendefinisikan nama-nama kantor
        $kantor1Nama = Kantor::find(1)->nama ?? 'Kantor 1';
        $kantor2Nama = Kantor::find(2)->nama ?? 'Kantor 2';
        $kantor3Nama = Kantor::find(3)->nama ?? 'Kantor 3';
        $kantor4Nama = Kantor::find(4)->nama ?? 'Kantor 4';

        // Menggunakan query yang disesuaikan dengan filter startDate dan endDate
        $kantor1Count = ProsesCpmi::when($start, fn($query) => $query->whereDate('created_at', '>=', $start))
            ->when($end, fn($query) => $query->whereDate('created_at', '<=', $end))
            ->whereHas('pendaftaran', fn($query) => $query->where('kantor_id', 1))
            ->where('status_id', 4)
            ->count();

        $kantor2Count = ProsesCpmi::when($start, fn($query) => $query->whereDate('created_at', '>=', $start))
            ->when($end, fn($query) => $query->whereDate('created_at', '<=', $end))
            ->whereHas('pendaftaran', fn($query) => $query->where('kantor_id', 2))
            ->where('status_id', 4)
            ->count();

        $kantor3Count = ProsesCpmi::when($start, fn($query) => $query->whereDate('created_at', '>=', $start))
            ->when($end, fn($query) => $query->whereDate('created_at', '<=', $end))
            ->whereHas('pendaftaran', fn($query) => $query->where('kantor_id', 3))
            ->where('status_id', 4)
            ->count();

        $kantor4Count = ProsesCpmi::when($start, fn($query) => $query->whereDate('created_at', '>=', $start))
            ->when($end, fn($query) => $query->whereDate('created_at', '<=', $end))
            ->whereHas('pendaftaran', fn($query) => $query->where('kantor_id', 4))
            ->where('status_id', 4)
            ->count();

        // Menghitung total dari keempat kantor
        $totalCount = $kantor1Count + $kantor2Count + $kantor3Count + $kantor4Count;

        // Data untuk chart
        return [
            'datasets' => [
                [
                    'label' => $kantor1Nama,
                    'data' => [$kantor1Count], // Jumlah data untuk Kantor 1
                    'borderColor' => 'rgba(255, 99, 132, 1)', // Warna untuk Kantor 1
                    'backgroundColor' => 'rgba(255, 99, 132, 0.2)', // Transparansi latar belakang
                    'fill' => true,
                    'type' => 'bar', // Menggunakan tipe 'bar' untuk dataset kantor
                ],
                [
                    'label' => $kantor2Nama,
                    'data' => [$kantor2Count], // Jumlah data untuk Kantor 2
                    'borderColor' => 'rgba(54, 162, 235, 1)', // Warna untuk Kantor 2
                    'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                    'fill' => true,
                    'type' => 'bar', // Menggunakan tipe 'bar' untuk dataset kantor
                ],
                [
                    'label' => $kantor3Nama,
                    'data' => [$kantor3Count], // Jumlah data untuk Kantor 3
                    'borderColor' => 'rgba(255, 206, 86, 1)', // Warna untuk Kantor 3
                    'backgroundColor' => 'rgba(255, 206, 86, 0.2)',
                    'fill' => true,
                    'type' => 'bar', // Menggunakan tipe 'bar' untuk dataset kantor
                ],
                [
                    'label' => $kantor4Nama,
                    'data' => [$kantor4Count], // Jumlah data untuk Kantor 4
                    'borderColor' => 'rgba(153, 102, 255, 1)', // Warna untuk Kantor 4
                    'backgroundColor' => 'rgba(153, 102, 255, 0.2)',
                    'fill' => true,
                    'type' => 'bar', // Menggunakan tipe 'bar' untuk dataset kantor
                ],
                [
                    'label' => 'TOTAL',
                    'data' => [$totalCount], // Jumlah total dari keempat kantor
                    'borderColor' => 'rgba(75, 192, 192, 1)', // Warna untuk total
                    'backgroundColor' => 'rgba(75, 192, 192, 0)', // Transparansi latar belakang
                    'fill' => false, // Tidak mengisi latar belakang
                    // 'borderDash' => [5, 5], // Garis putus-putus
                    'type' => 'line', // Menggunakan tipe 'line' untuk total
                    'tension' => 0.4, // Menambahkan smooth curve pada line chart
                ],
            ],
            'labels' => [''], // Label untuk x-axis
        ];
    }

    protected function getType(): string
    {
        return 'bar'; // Menggunakan chart tipe 'bar' secara default
    }
}
