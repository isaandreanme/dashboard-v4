<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\Marketing;
use App\Models\Pelatihan;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index()
    {
        // Ambil semua data Pelatihan dari database
        $pelatihan = Pelatihan::all();
        $agency = Agency::whereNotIn('id', [1, 2])->get();
        $marketing = Marketing::all();


        // Kirim data ke view landing.blade.php
        return view('landing', compact('pelatihan', 'agency', 'marketing'));
    }
}
