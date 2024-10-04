<?php

namespace App\Filament\Exports;

use App\Models\Pendaftaran;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class PendaftaranExporter extends Exporter
{
    protected static ?string $model = Pendaftaran::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
            ExportColumn::make('nama'),
            ExportColumn::make('nomor_ktp'),
            ExportColumn::make('tempat_lahir'),
            ExportColumn::make('tgl_lahir'),
            ExportColumn::make('nomor_telp'),
            ExportColumn::make('nomor_kk'),
            ExportColumn::make('nama_wali'),
            ExportColumn::make('nomor_ktp_wali'),
            ExportColumn::make('alamat'),
            ExportColumn::make('rtrw'),
            ExportColumn::make('tanggal_pra_medical'),
            ExportColumn::make('pra_medical'),
            ExportColumn::make('file_ktp'),
            ExportColumn::make('file_ktp_wali'),
            ExportColumn::make('file_kk'),
            ExportColumn::make('file_akta_lahir'),
            ExportColumn::make('file_surat_nikah'),
            ExportColumn::make('file_surat_ijin'),
            ExportColumn::make('file_ijazah'),
            ExportColumn::make('file_tambahan'),
            ExportColumn::make('data_lengkap'),
            ExportColumn::make('kantor'),
            ExportColumn::make('tujuan'),
            ExportColumn::make('pengalaman'),
            ExportColumn::make('tanggal_pra_bpjs'),
            ExportColumn::make('email_siapkerja'),
            ExportColumn::make('tglsiapkerja'),
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
            ExportColumn::make('province_id'),
            ExportColumn::make('regency_id'),
            ExportColumn::make('district_id'),
            ExportColumn::make('village_id'),
            ExportColumn::make('kantor_id'),
            ExportColumn::make('pengalaman_id'),
            ExportColumn::make('sponsor_id'),
            ExportColumn::make('tujuan_id'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Export Ke Exel - Marketing Sudah Selesai Dan ' . number_format($export->successful_rows) . ' ' . str('Baris')->plural($export->successful_rows) . ' Berhasil.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('Baris')->plural($failedRowsCount) . ' Export Gagal.';
        }

        return $body;
    }
}
