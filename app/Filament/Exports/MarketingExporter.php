<?php

namespace App\Filament\Exports;

use App\Models\Marketing;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class MarketingExporter extends Exporter
{
    protected static ?string $model = Marketing::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
            ExportColumn::make('deleted_at'),
            ExportColumn::make('foto'),
            ExportColumn::make('code_hk'),
            ExportColumn::make('code_tw'),
            ExportColumn::make('code_sgp'),
            ExportColumn::make('code_my'),
            ExportColumn::make('nomor_hp'),
            ExportColumn::make('get_job'),
            ExportColumn::make('nama'),
            ExportColumn::make('national'),
            ExportColumn::make('kelamin'),
            ExportColumn::make('lulusan'),
            ExportColumn::make('agama'),
            ExportColumn::make('anakke'),
            ExportColumn::make('brother'),
            ExportColumn::make('sister'),
            ExportColumn::make('usia'),
            ExportColumn::make('tanggal_lahir'),
            ExportColumn::make('status_nikah'),
            ExportColumn::make('tinggi_badan'),
            ExportColumn::make('berat_badan'),
            ExportColumn::make('son'),
            ExportColumn::make('daughter'),
            ExportColumn::make('careofbabies'),
            ExportColumn::make('careoftoddler'),
            ExportColumn::make('careofchildren'),
            ExportColumn::make('careofelderly'),
            ExportColumn::make('careofdisabled'),
            ExportColumn::make('careofbedridden'),
            ExportColumn::make('careofpet'),
            ExportColumn::make('householdworks'),
            ExportColumn::make('carwashing'),
            ExportColumn::make('gardening'),
            ExportColumn::make('cooking'),
            ExportColumn::make('driving'),
            ExportColumn::make('hongkong'),
            ExportColumn::make('singapore'),
            ExportColumn::make('taiwan'),
            ExportColumn::make('malaysia'),
            ExportColumn::make('macau'),
            ExportColumn::make('middleeast'),
            ExportColumn::make('other'),
            ExportColumn::make('homecountry'),
            ExportColumn::make('spokenenglish'),
            ExportColumn::make('spokencantonese'),
            ExportColumn::make('spokenmandarin'),
            ExportColumn::make('remark'),
            // Perbaikan untuk kolom pengalaman menggunakan json_encode
            ExportColumn::make('pengalaman')
            ->listAsJson(),
            ExportColumn::make('babi'),
            ExportColumn::make('liburbukanhariminggu'),
            ExportColumn::make('berbagikamar'),
            ExportColumn::make('takutanjing'),
            ExportColumn::make('merokok'),
            ExportColumn::make('alkohol'),
            ExportColumn::make('pernahsakit'),
            ExportColumn::make('ketsakit'),
            ExportColumn::make('tujuan_id'),
            ExportColumn::make('kantor_id'),
            ExportColumn::make('marketing_id'),
            ExportColumn::make('pengalaman_id'),
            ExportColumn::make('dapatjob'),
            ExportColumn::make('pendaftaran_id'),
            ExportColumn::make('proses_cpmi_id'),
            ExportColumn::make('sales_id'),
            ExportColumn::make('agency_id'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $successfulRows = $export->successful_rows;
        $failedRowsCount = $export->getFailedRowsCount();

        $body = 'Export Ke Exel - Marketing Sudah Selesai Dan ' . number_format($successfulRows) . ' ' . str('Baris')->plural($successfulRows) . ' Berhasil.';

        if ($failedRowsCount > 0) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('Baris')->plural($failedRowsCount) . ' Export Gagal.';
        }

        return $body;
    }
}
