<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProsesCpmi;
use App\Models\Status;
use App\Models\Kantor;
use App\Models\Pendaftaran;
use App\Models\Marketing;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use PDF;

class LaporanController extends Controller
{
    use InteractsWithPageFilters;

    public function index(Request $request)
    {
        // Ambil filter tanggal dari request (bila ada)
        $start = $request->input('startDate');
        $end = $request->input('endDate');

        // Ambil status dan kantor terkait
        $statuses = Status::whereIn('id', [1, 2, 3, 4, 5, 6])->get();
        $kantors = Kantor::whereIn('id', [1, 2, 3, 4])->get();

        // Inisialisasi variabel data yang akan ditampilkan
        $jumlahData = [];
        $totalPerStatus = array_fill(1, 6, 0); // Total per status_id (1-6)
        $grandTotal = 0;

        // Inisialisasi variabel untuk kolom tambahan seperti Pra Medical, Siap Kerja, dll.
        $jumlahPraMedical = [];
        $jumlahSiapKerja = [];
        $jumlahBp2mi = [];
        $jumlahDapatJob = [];
        $jumlahPenerbangan = [];

        foreach ($kantors as $kantor) {
            $totalPerKantor = 0;

            foreach ($statuses as $status) {
                // Hitung jumlah data berdasarkan status dan kantor
                $count = ProsesCpmi::when($start, function ($query) use ($start) {
                    return $query->whereDate('created_at', '>=', $start);
                })
                    ->when($end, function ($query) use ($end) {
                        return $query->whereDate('created_at', '<=', $end);
                    })
                    ->where('status_id', $status->id)
                    ->whereHas('pendaftaran', function ($query) use ($kantor) {
                        $query->where('kantor_id', $kantor->id);
                    })
                    ->count();

                // Simpan jumlah data per kantor dan status
                $jumlahData[$kantor->nama][$status->nama] = $count;
                $totalPerKantor += $count;
                $totalPerStatus[$status->id] += $count;
            }

            // Hitung Pra Medical hanya jika status_id 1 atau 2
            $countPraMedical = ProsesCpmi::when($start, function ($query) use ($start) {
                return $query->whereHas('pendaftaran', function ($query) use ($start) {
                    return $query->whereDate('tanggal_pra_medical', '>=', $start);
                });
            })
                ->when($end, function ($query) use ($end) {
                    return $query->whereHas('pendaftaran', function ($query) use ($end) {
                        return $query->whereDate('tanggal_pra_medical', '<=', $end);
                    });
                })
                ->whereHas('pendaftaran', function ($query) use ($kantor) {
                    $query->whereNotNull('tanggal_pra_medical') // Pastikan tanggal_pra_medical tidak null
                        ->where('kantor_id', $kantor->id); // Filter berdasarkan kantor
                })
                ->whereIn('status_id', [1, 2]) // Hanya jika status_id 1 atau 2
                ->count();

            // Hitung Siap Kerja dari model ProsesCpmi (status_id ada di ProsesCpmi)
            $countSiapKerja = ProsesCpmi::when($start, function ($query) use ($start) {
                return $query->whereDate('tglsiapkerja', '>=', $start);
            })
                ->when($end, function ($query) use ($end) {
                    return $query->whereDate('tglsiapkerja', '<=', $end);
                })
                ->whereNotNull('tglsiapkerja')
                ->whereHas('pendaftaran', function ($query) use ($kantor) {
                    $query->where('kantor_id', $kantor->id);
                })
                ->whereIn('status_id', [1, 2]) // Hanya jika status_id 1 atau 2
                ->count();

            // Hitung ID BP2MI dari model ProsesCpmi (status_id ada di ProsesCpmi)
            $countBp2mi = ProsesCpmi::when($start, function ($query) use ($start) {
                return $query->whereDate('tgl_bp2mi', '>=', $start);
            })
                ->when($end, function ($query) use ($end) {
                    return $query->whereDate('tgl_bp2mi', '<=', $end);
                })
                ->whereNotNull('tgl_bp2mi')
                ->whereHas('pendaftaran', function ($query) use ($kantor) {
                    $query->where('kantor_id', $kantor->id);
                })
                ->whereIn('status_id', [1, 2]) // Hanya jika status_id 1 atau 2
                ->count();

            // Hitung Dapat Job dari model Marketing (status_id ada di ProsesCpmi)
            $countDapatJob = Marketing::when($start, function ($query) use ($start) {
                return $query->whereDate('tgl_job', '>=', $start);
            })
                ->when($end, function ($query) use ($end) {
                    return $query->whereDate('tgl_job', '<=', $end);
                })
                ->whereNotNull('tgl_job')
                ->whereHas('pendaftaran', function ($query) use ($kantor) {
                    $query->where('kantor_id', $kantor->id);
                })
                ->whereHas('prosesCpmi', function ($query) {
                    $query->whereIn('status_id', [1, 2]); // Ambil status_id dari relasi ProsesCpmi
                })
                ->count();

            // Hitung Penerbangan dari model ProsesCpmi (tetap sama, tidak dipengaruhi status_id)
            $countPenerbangan = ProsesCpmi::when($start, function ($query) use ($start) {
                return $query->whereDate('tanggal_penerbangan', '>=', $start);
            })
                ->when($end, function ($query) use ($end) {
                    return $query->whereDate('tanggal_penerbangan', '<=', $end);
                })
                ->whereNotNull('tanggal_penerbangan')
                ->whereHas('pendaftaran', function ($query) use ($kantor) {
                    $query->where('kantor_id', $kantor->id);
                })
                ->count();

            // Simpan hasil ke dalam array
            $jumlahPraMedical[$kantor->nama] = $countPraMedical;
            $jumlahSiapKerja[$kantor->nama] = $countSiapKerja;
            $jumlahBp2mi[$kantor->nama] = $countBp2mi;
            $jumlahDapatJob[$kantor->nama] = $countDapatJob;
            $jumlahPenerbangan[$kantor->nama] = $countPenerbangan;

            // Total per kantor
            $jumlahData[$kantor->nama]['total'] = $totalPerKantor;
            $grandTotal += $totalPerKantor;
        }

        // Kirim data ke view laporan.blade.php
        return view('laporan', compact(
            'jumlahData',
            'statuses',
            'totalPerStatus',
            'grandTotal',
            'jumlahPraMedical',
            'jumlahSiapKerja',
            'jumlahBp2mi',
            'jumlahDapatJob',
            'jumlahPenerbangan',
            'kantors',
            'start',
            'end'
        ));
    }

    public function generatePdf(Request $request)
    {
        // Sama dengan metode index, tetapi hasilnya di-generate sebagai PDF
        // $start = $this->filters['startDate'] ?? null;
        // $end = $this->filters['endDate'] ?? null;

        $start = $request->input('startDate');
        $end = $request->input('endDate');

        $statuses = Status::whereIn('id', [1, 2, 3, 4, 5, 6])->get();
        $kantors = Kantor::whereIn('id', [1, 2, 3, 4])->get();

        $jumlahData = [];
        $totalPerStatus = array_fill(1, 6, 0);
        $grandTotal = 0;

        $jumlahPraMedical = [];
        $jumlahSiapKerja = [];
        $jumlahBp2mi = [];
        $jumlahDapatJob = [];
        $jumlahPenerbangan = [];

        foreach ($kantors as $kantor) {
            $totalPerKantor = 0;

            foreach ($statuses as $status) {
                $count = ProsesCpmi::when($start, function ($query) use ($start) {
                    return $query->whereDate('created_at', '>=', $start);
                })
                    ->when($end, function ($query) use ($end) {
                        return $query->whereDate('created_at', '<=', $end);
                    })
                    ->where('status_id', $status->id)
                    ->whereHas('pendaftaran', function ($query) use ($kantor) {
                        $query->where('kantor_id', $kantor->id);
                    })
                    ->count();

                $jumlahData[$kantor->nama][$status->nama] = $count;
                $totalPerKantor += $count;
                $totalPerStatus[$status->id] += $count;
            }

            $countPraMedical = ProsesCpmi::when($start, function ($query) use ($start) {
                return $query->whereHas('pendaftaran', function ($query) use ($start) {
                    return $query->whereDate('tanggal_pra_medical', '>=', $start);
                });
            })
                ->when($end, function ($query) use ($end) {
                    return $query->whereHas('pendaftaran', function ($query) use ($end) {
                        return $query->whereDate('tanggal_pra_medical', '<=', $end);
                    });
                })
                ->whereHas('pendaftaran', function ($query) use ($kantor) {
                    $query->whereNotNull('tanggal_pra_medical')
                        ->where('kantor_id', $kantor->id);
                })
                ->whereIn('status_id', [1, 2])
                ->count();

            $countSiapKerja = ProsesCpmi::when($start, function ($query) use ($start) {
                return $query->whereDate('tglsiapkerja', '>=', $start);
            })
                ->when($end, function ($query) use ($end) {
                    return $query->whereDate('tglsiapkerja', '<=', $end);
                })
                ->whereNotNull('tglsiapkerja')
                ->whereHas('pendaftaran', function ($query) use ($kantor) {
                    $query->where('kantor_id', $kantor->id);
                })
                ->whereIn('status_id', [1, 2])
                ->count();

            $countBp2mi = ProsesCpmi::when($start, function ($query) use ($start) {
                return $query->whereDate('tgl_bp2mi', '>=', $start);
            })
                ->when($end, function ($query) use ($end) {
                    return $query->whereDate('tgl_bp2mi', '<=', $end);
                })
                ->whereNotNull('tgl_bp2mi')
                ->whereHas('pendaftaran', function ($query) use ($kantor) {
                    $query->where('kantor_id', $kantor->id);
                })
                ->whereIn('status_id', [1, 2])
                ->count();

            $countDapatJob = Marketing::when($start, function ($query) use ($start) {
                return $query->whereDate('tgl_job', '>=', $start);
            })
                ->when($end, function ($query) use ($end) {
                    return $query->whereDate('tgl_job', '<=', $end);
                })
                ->whereNotNull('tgl_job')
                ->whereHas('pendaftaran', function ($query) use ($kantor) {
                    $query->where('kantor_id', $kantor->id);
                })
                ->whereHas('prosesCpmi', function ($query) {
                    $query->whereIn('status_id', [1, 2]);
                })
                ->count();

            $countPenerbangan = ProsesCpmi::when($start, function ($query) use ($start) {
                return $query->whereDate('tanggal_penerbangan', '>=', $start);
            })
                ->when($end, function ($query) use ($end) {
                    return $query->whereDate('tanggal_penerbangan', '<=', $end);
                })
                ->whereNotNull('tanggal_penerbangan')
                ->whereHas('pendaftaran', function ($query) use ($kantor) {
                    $query->where('kantor_id', $kantor->id);
                })
                ->count();

            $jumlahPraMedical[$kantor->nama] = $countPraMedical;
            $jumlahSiapKerja[$kantor->nama] = $countSiapKerja;
            $jumlahBp2mi[$kantor->nama] = $countBp2mi;
            $jumlahDapatJob[$kantor->nama] = $countDapatJob;
            $jumlahPenerbangan[$kantor->nama] = $countPenerbangan;

            $jumlahData[$kantor->nama]['total'] = $totalPerKantor;
            $grandTotal += $totalPerKantor;
        }

        $pdf = FacadePdf::loadView('laporan', compact(
            'jumlahData',
            'statuses',
            'totalPerStatus',
            'grandTotal',
            'jumlahPraMedical',
            'jumlahSiapKerja',
            'jumlahBp2mi',
            'jumlahDapatJob',
            'jumlahPenerbangan',
            'kantors',
            'start',
            'end'
        ));

        $appName = env('COMPANY_NAME', 'DefaultApp');

        // Get current date and time
        $timestamp = date('Ymd_His'); // Format: YYYYMMDD_HHMMSS

        // Generate filename with app name and timestamp
        $fileName = $appName . '_laporan_' . $timestamp . '.pdf';

        // Return the PDF as a downloadable file with the new filename
        return $pdf->download($fileName);
    }
}
