<?php

namespace App\Filament\Exports;

use App\Models\ProsesCpmi;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class ProsesCpmiExporter extends Exporter
{
    protected static ?string $model = ProsesCpmi::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('tanggal_pra_bpjs'),
            ExportColumn::make('tanggal_ujk'),
            ExportColumn::make('tglsiapkerja'),
            ExportColumn::make('email_siapkerja'),
            ExportColumn::make('tgl_bp2mi'),
            ExportColumn::make('no_id_pmi'),
            ExportColumn::make('file_pp'),
            ExportColumn::make('tanggal_medical_full'),
            ExportColumn::make('tanggal_ec'),
            ExportColumn::make('tanggal_visa'),
            ExportColumn::make('tanggal_bpjs_purna'),
            ExportColumn::make('tanggal_teto'),
            ExportColumn::make('tanggal_pap'),
            ExportColumn::make('tanggal_penerbangan'),
            ExportColumn::make('tanggal_in_toyo'),
            ExportColumn::make('tanggal_in_agency'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
            ExportColumn::make('pendaftaran_id'),
            ExportColumn::make('status_id'),
            ExportColumn::make('tujuan_id'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Export Ke Exel - Proses CPMI Sudah Selesai Dan ' . number_format($export->successful_rows) . ' ' . str('Baris')->plural($export->successful_rows) . ' Berhasil.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('Baris')->plural($failedRowsCount) . ' Export Gagal.';
        }

        return $body;
    }
}
