<?php

namespace App\Filament\Pages;

use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Pages\Page;
use Filament\Infolists\Infolist;
use Illuminate\Support\Facades\Auth; // Import Auth facade
use App\Models\Pendaftaran; // Import model Pendaftaran
use App\Models\Marketing; // Import model Marketing
use App\Models\ProsesCpmi;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Section;
use IbrahimBougaoua\FilaProgress\Infolists\Components\ProgressBarEntry;

class Proses extends Page implements HasInfolists
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.pages.proses';

    protected static ?string $navigationLabel = 'DETAILS';
    protected static ?string $title = 'DETAILS';
    protected ?string $heading = 'DETAILS';
    protected ?string $subheading = 'View Details';

    protected static ?int $navigationSort = 20;

    public function infolist(Infolist $infolist): Infolist
    {
        // Ambil pengguna yang sedang login
        $user = Auth::user();
        // Ambil data Pendaftaran untuk pengguna yang sedang login
        $pendaftaran = Pendaftaran::where('user_id', $user->id)->first();

        // Cek apakah pendaftaran ditemukan
        if ($pendaftaran) {
            // Ambil data ProsesCpmi untuk pengguna yang sedang login
            $prosesCpmi = ProsesCpmi::where('pendaftaran_id', $pendaftaran->id)->first();

            // Ambil data Marketing untuk pengguna yang sedang login
            $marketing = Marketing::where('pendaftaran_id', $pendaftaran->id)->first();
        } else {
            // Jika tidak ditemukan, set variabel menjadi null atau nilai default
            $prosesCpmi = null;
            $marketing = null;
        }


        return $infolist
            ->record($user) // Mengatur record ke pengguna yang sedang login
            ->schema([
                Grid::make([
                    'default' => 2,
                    'sm' => 2,
                    'md' => 3,
                    'lg' => 4,
                    'xl' => 6,
                    '2xl' => 8,
                ])
                    ->schema([
                        Section::make('Akun Portal')
                            ->description('The items you have selected for purchase')
                            ->icon('heroicon-o-lock-closed')
                            ->schema([
                                TextEntry::make('name')
                                    ->label('Nama Akun'),
                                TextEntry::make('email')
                                    ->label('Email'),
                            ])->columns(2),
                        Section::make('Pendaftaran')
                            ->description('The items you have selected for purchase')
                            ->icon('heroicon-o-clipboard-document-check')
                            ->schema([
                                TextEntry::make('nama')
                                    ->label('Nama')
                                    ->default($pendaftaran->nama ?? 'Tidak ada data'), // Menggunakan default untuk menampilkan KTP

                                TextEntry::make('nomor_ktp')
                                    ->label('Nomor KTP')
                                    ->default($pendaftaran->nomor_ktp ?? 'Tidak ada data'), // Menggunakan default untuk menampilkan KTP
                            ])->columns(2),
                        Section::make('Proses Status')
                            ->description('The items you have selected for purchase')
                            ->icon('heroicon-o-arrow-path-rounded-square')
                            ->schema([
                                // ProgressBarEntry::make('PROGRESS')
                                //     ->label('PROGRESS')
                                //     ->getStateUsing(function ($record) {
                                //         // Cek apakah status_id adalah 3
                                //         if ($record->status_id == 3) {
                                //             // Jika status_id adalah 3, langsung kembalikan progres 100%
                                //             return [
                                //                 'total' => 100,
                                //                 'progress' => 100,
                                //             ];
                                //         }

                                //         // Cek apakah status_id adalah 1 atau 2
                                //         if (!in_array($record->status_id, [1, 2])) {
                                //             // Jika status_id bukan 1 atau 2, progres tidak dihitung (return null atau 0 progres)
                                //             return [
                                //                 'total' => 0,
                                //                 'progress' => 0,
                                //             ];
                                //         }

                                //         // Daftar field tanggal yang ingin diperiksa (semua berupa tanggal)
                                //         $fields = [
                                //             'tanggal_pra_bpjs',
                                //             'tanggal_ujk',
                                //             'tglsiapkerja',
                                //             'tgl_bp2mi',
                                //             'tanggal_medical_full',
                                //             'tanggal_ec',
                                //             'tanggal_visa',
                                //             'tanggal_bpjs_purna',
                                //             'tanggal_pap',
                                //             'tanggal_penerbangan',
                                //         ];

                                //         // Mengakses tanggal_pra_medical dan data_lengkap dari relasi pendaftaran
                                //         if ($record->pendaftaran) {
                                //             $fields[] = 'pendaftaran.tanggal_pra_medical';  // Field untuk tanggal_pra_medical
                                //             $fields[] = 'pendaftaran.data_lengkap';          // Field boolean untuk data_lengkap
                                //         }

                                //         // Menghitung total field
                                //         $total = count($fields);

                                //         // Menghitung field yang terisi (tidak null atau boolean true untuk data_lengkap)
                                //         $filled = collect($fields)
                                //             ->reduce(function ($count, $field) use ($record) {
                                //                 // Memeriksa field dari relasi (misalnya pendaftaran.tanggal_pra_medical)
                                //                 if (str_contains($field, '.')) {
                                //                     [$relation, $fieldName] = explode('.', $field);
                                //                     $value = $record->$relation->$fieldName;
                                //                     // Jika field adalah 'data_lengkap', harus bernilai true
                                //                     if ($fieldName === 'data_lengkap') {
                                //                         return $count + ($value === true ? 1 : 0);
                                //                     }
                                //                     // Field tanggal harus tidak null (misalnya tanggal_pra_medical)
                                //                     return $count + (!is_null($value) ? 1 : 0);
                                //                 }
                                //                 // Memeriksa field biasa (tanggal di record) yang tidak boleh null
                                //                 return $count + (!is_null($record->$field) ? 1 : 0);
                                //             }, 0);

                                //         // Menghitung persentase progress
                                //         $progress = ($filled / $total) * 100;

                                //         // Debugging log untuk membantu memeriksa field yang terisi
                                //         logger('Total fields: ' . $total);
                                //         logger('Filled fields: ' . $filled);
                                //         logger('Progress: ' . $progress);

                                //         // Mengembalikan total dan progress dalam bentuk persentase
                                //         return [
                                //             'total' => 100,  // Persentase total
                                //             'progress' => $progress,  // Persentase progress
                                //         ];
                                //     }),

                                TextEntry::make('status_id')
                                    ->label('Status')
                                    ->default($prosesCpmi->status->nama ?? 'Tidak ada status'), // Menampilkan nama status
                            ])->columns(2),
                        Section::make('Marketing')
                            ->description('The items you have selected for purchase')
                            ->icon('heroicon-o-check-circle')
                            ->schema([
                                TextEntry::make('agency_id')
                                    ->label('Agency')
                                    ->default($marketing->agency->nama ?? 'Tidak ada agency'), // Menampilkan nama agency

                                TextEntry::make('sales_id')
                                    ->label('Sales Marketing')
                                    ->default($marketing->sales->nama ?? 'Tidak ada sales'), // Menampilkan nama Sales
                            ])->columns(2)
                    ])
            ]);
    }
    protected function getHeaderActions(): array
    {
        $user = Auth::user();
        // Ambil data Pendaftaran untuk pengguna yang sedang login
        $pendaftaran = Pendaftaran::where('user_id', $user->id)->first();

        // Cek apakah pendaftaran ditemukan
        if ($pendaftaran) {
            // Ambil data ProsesCpmi untuk pengguna yang sedang login
            $prosesCpmi = ProsesCpmi::where('pendaftaran_id', $pendaftaran->id)->first();

            // Ambil data Marketing untuk pengguna yang sedang login
            $marketing = Marketing::where('pendaftaran_id', $pendaftaran->id)->first();
        } else {
            // Jika tidak ditemukan, set variabel menjadi null atau nilai default
            $prosesCpmi = null;
            $marketing = null;
        }
        return [
            ActionGroup::make([
                // Tombol untuk Hongkong
                Action::make('DownloadPdfHongkong')
                    ->label('Biodata For Hongkong')
                    ->icon('heroicon-o-printer')
                    ->url(fn() => $marketing ? route('hongkong.pdf.download', ['id' => $marketing->id]) : '#')
                    ->openUrlInNewTab()
                    ->color('success'),

                // Tombol untuk Taiwan
                Action::make('DownloadPdfTaiwan')
                    ->label('Biodata For Taiwan')
                    ->icon('heroicon-o-printer')
                    ->url(fn() => $marketing ? route('taiwan.pdf.download', ['id' => $marketing->id]) : '#')
                    ->openUrlInNewTab()
                    ->color('success'),

                // Tombol untuk Singapore
                Action::make('DownloadPdfSingapore')
                    ->label('Biodata For Singapore')
                    ->icon('heroicon-o-printer')
                    ->url(fn() => $marketing ? route('singapore.pdf.download', ['id' => $marketing->id]) : '#')
                    ->openUrlInNewTab()
                    ->color('success'),

                // Tombol untuk Malaysia
                Action::make('DownloadPdfMalaysia')
                    ->label('Biodata For Malaysia')
                    ->icon('heroicon-o-printer')
                    ->url(fn() => $marketing ? route('malaysia.pdf.download', ['id' => $marketing->id]) : '#')
                    ->openUrlInNewTab()
                    ->color('success'),
            ])
                ->label('Unduh Biodata')
                ->icon('heroicon-m-ellipsis-vertical')
                // ->size(ActionSize::Small)
                ->color('primary')
                ->button()
        ];
    }
}
