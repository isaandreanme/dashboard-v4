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
use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section;
use IbrahimBougaoua\FilaProgress\Infolists\Components\ProgressBarEntry;
use Illuminate\Contracts\View\View;

class Proses extends Page implements HasInfolists
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.pages.proses';

    protected static ?string $navigationLabel = 'DETAILS';
    protected static ?string $title = 'DETAILS';
    protected ?string $heading = 'DETAILS';
    protected ?string $subheading = 'View Details Akun CPMI';

    protected static ?int $navigationSort = 20;

    public static function shouldRegisterNavigation(): bool
    {
        return !Auth::user()->is_agency; // Hide navigation for users with is_agency role
    }


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
                    // 'default' => 2,
                    'sm' => 1,
                    'md' => 2,
                    'lg' => 2,
                    'xl' => 2,
                    '2xl' => 2,
                ])
                    ->schema([
                        Group::make()
                            ->schema([
                                Section::make('Proses Status')
                                    ->description('Status Dan Marketing')
                                    ->icon('heroicon-o-arrow-path-rounded-square')
                                    ->schema([
                                        Fieldset::make('')
                                            ->schema([
                                                TextEntry::make('status_id')
                                                    ->label('Status')
                                                    ->default($prosesCpmi->status->nama ?? 'Tidak ada status'),

                                                TextEntry::make('agency_id')
                                                    ->label('Agency')
                                                    ->default($marketing->agency->nama ?? 'Tidak ada agency'), // Menampilkan nama agency

                                                TextEntry::make('sales_id')
                                                    ->label('Sales Marketing')
                                                    ->default($marketing->sales->nama ?? 'Tidak ada sales'), // Menampilkan nama Sales
                                            ])->columns(3),
                                    ])->columns(2),

                                Section::make('Pendaftaran')
                                    ->description('Data Pendaftaran')
                                    ->icon('heroicon-o-clipboard-document-check')
                                    ->schema([
                                        Fieldset::make('')
                                            ->schema([
                                                ImageEntry::make('foto')
                                                    ->label('')
                                                    // ->square()
                                                    // ->circular()
                                                    ->default($marketing->foto ?? 'Tidak ada data'), // Menggunakan default untuk menampilkan KTP

                                                TextEntry::make('nama')
                                                    ->label('Nama')
                                                    ->default($pendaftaran->nama ?? 'Tidak ada data'), // Menggunakan default untuk menampilkan KTP

                                                TextEntry::make('nomor_ktp')
                                                    ->label('Nomor KTP')
                                                    ->default($pendaftaran->nomor_ktp ?? 'Tidak ada data'), // Menggunakan default untuk menampilkan KTP
                                            ])->columns(3),
                                        Fieldset::make('')
                                            ->schema([
                                                TextEntry::make('name')
                                                    ->label('Nama Akun'),
                                                TextEntry::make('email')
                                                    ->label('Email'),
                                            ])->columns(2),
                                    ])->columns(3),

                            ]),
                        Group::make()
                            ->schema([
                                Section::make('Pemenuhan')
                                    ->description('Jika Data Tidak Ada CPMI Belum Melaksanakan Proses')
                                    ->icon('heroicon-o-arrow-path-rounded-square')
                                    ->schema([
                                        Fieldset::make('')
                                            ->schema([
                                                TextEntry::make('tanggal_pra_medical')
                                                    ->label('Pra Medical')
                                                    ->default($pendaftaran->tanggal_pra_medical ?? 'Tidak ada data'), // Menggunakan default untuk menampilkan KTP
                                                TextEntry::make('tanggal_pra_bpjs')
                                                    ->label('Pra BPJS')
                                                    ->default($prosesCpmi->tanggal_pra_bpjs ?? 'Tidak ada data'), // Menampilkan nama status
                                                TextEntry::make('tanggal_ujk')
                                                    ->label('UJK')
                                                    ->default($prosesCpmi->tanggal_ujk ?? 'Tidak ada data'), // Menampilkan nama status
                                                TextEntry::make('tglsiapkerja')
                                                    ->label('Siap Kerja')
                                                    ->default($prosesCpmi->tglsiapkerja ?? 'Tidak ada data'), // Menampilkan nama status
                                                TextEntry::make('tgl_bp2mi')
                                                    ->label('ID BP2MI')
                                                    ->default($prosesCpmi->tgl_bp2mi ?? 'Tidak ada data'), // Menampilkan nama status
                                                TextEntry::make('tanggal_medical_full')
                                                    ->label('Medical Full')
                                                    ->default($prosesCpmi->tanggal_medical_full ?? 'Tidak ada data'), // Menampilkan nama status
                                                TextEntry::make('tanggal_ec')
                                                    ->label('EC (Kontrak)')
                                                    ->default($prosesCpmi->tanggal_ec ?? 'Tidak ada data'), // Menampilkan nama status
                                                TextEntry::make('tanggal_visa')
                                                    ->label('Visa')
                                                    ->default($prosesCpmi->tanggal_visa ?? 'Tidak ada data'), // Menampilkan nama status
                                                TextEntry::make('tanggal_bpjs_purna')
                                                    ->label('BPJS Purna')
                                                    ->default($prosesCpmi->tanggal_bpjs_purna ?? 'Tidak ada data'), // Menampilkan nama status
                                                TextEntry::make('tanggal_teto')
                                                    ->label('TETO')
                                                    ->default($prosesCpmi->tanggal_teto ?? 'Tidak ada data'), // Menampilkan nama status
                                                TextEntry::make('tanggal_pap')
                                                    ->label('PAP')
                                                    ->default($prosesCpmi->tanggal_pap ?? 'Tidak ada data'), // Menampilkan nama status
                                                TextEntry::make('tanggal_penerbangan')
                                                    ->label('Jadwal Penerbangan')
                                                    ->default($prosesCpmi->tanggal_penerbangan ?? 'Tidak ada data'), // Menampilkan nama status
                                            ])->columns(),

                                    ])->columns(2)->collapsible('true'),
                            ]),
                    ]),
                Section::make('DOKUMEN PENDAFTARAN CPMI')
                    ->description('Data Yang Di Berikan Kepada Pendaftaran')
                    ->icon('heroicon-o-document-text')
                    ->schema([
                        TextEntry::make('file_ktp')->label('Upload KTP')
                            ->default($pendaftaran->file_ktp ?? 'Tidak ada data'),
                        TextEntry::make('file_ktp_wali')->label('Upload KTP Wali')
                            ->default($pendaftaran->file_ktp_wali ?? 'Tidak ada data'),
                        TextEntry::make('file_kk')->label('Upload KK')
                            ->default($pendaftaran->tanggalfile_kk_pra_medical ?? 'Tidak ada data'),
                        TextEntry::make('file_akta_lahir')->label('Upload Akta Lahir')
                            ->default($pendaftaran->file_akta_lahir ?? 'Tidak ada data'),
                        TextEntry::make('file_surat_nikah')->label('Upload Surat Nikah')
                            ->default($pendaftaran->file_surat_nikah ?? 'Tidak ada data'),
                        TextEntry::make('file_surat_ijin')->label('Upload Surat Ijin')
                            ->default($pendaftaran->file_surat_ijin ?? 'Tidak ada data'),
                        TextEntry::make('file_ijazah')->label('Upload Ijazah')
                            ->default($pendaftaran->file_ijazah ?? 'Tidak ada data'),
                        TextEntry::make('file_tambahan')->label('Upload File Tambahan')
                            ->default($pendaftaran->file_tambahan ?? 'Tidak ada data'),
                    ])->columns(4)->collapsed(),
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

    public function getFooter(): ?View
    {
        return view('filament.settings.custom-footer');
    }
}
