<?php

namespace App\Http\Controllers;

use App\Models\Kantor;
use App\Models\Marketing;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Dompdf\Dompdf;
use Dompdf\Options;

class MalaysiaController extends Controller
{
    public function download($id)
    {
        // Validasi ID
        if (!is_numeric($id)) {
            return response()->json(['error' => 'Format ID tidak valid.'], 400);
        }

        // Dapatkan data Marketing beserta relasi sales
        $marketing = Marketing::with('sales')->find($id);
        if (!$marketing) {
            return response()->json(['error' => 'Data marketing tidak ditemukan.'], 404);
        }

        // Dapatkan data Pendaftaran dan Kantor terkait jika tersedia
        $pendaftaran = Pendaftaran::find($marketing->pendaftaran_id);
        $kantor = $pendaftaran ? Kantor::find($pendaftaran->kantor_id) : null;

        // Periksa apakah 'code_my' ada di model Marketing
        if (empty($marketing->code_my)) {
            return response()->json(['error' => 'code_my pada Marketing tidak valid atau kosong.'], 400);
        }

        // Render tampilan ke HTML
        $htmlContent = View::make('malaysia', [
            'marketing' => $marketing,
            'pendaftaran' => $pendaftaran,
            'kantor' => $kantor,
            'sales' => $marketing->sales,
        ])->render();

        // Tentukan nama file dengan timestamp dan nama perusahaan
        $timestamp = now()->format('Ymd_His');
        $appName = env('COMPANY_NAME', 'DefaultApp');
        $filename = $marketing->code_my . '_' . $appName . '_MY_' . $timestamp . '.pdf';

        // Atur opsi untuk DOMPDF
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true); // Jika Anda memiliki asset seperti gambar, pastikan ini diaktifkan

        // Inisialisasi DOMPDF
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($htmlContent);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Simpan PDF ke storage
        $pdfPath = storage_path("app/public/{$filename}");
        file_put_contents($pdfPath, $dompdf->output());

        // Kembalikan PDF sebagai unduhan
        return response()->download($pdfPath)->deleteFileAfterSend(true);
    }
}
