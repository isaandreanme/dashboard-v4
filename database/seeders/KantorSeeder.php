<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KantorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kantors')->insert([
            [
                'nama' => 'JAKARTA',
                'penanggungjawab' => 'Budi Santoso',
                'nomortelp' => '081234567890',
                'alamat' => 'Jl. Thamrin No. 1, Jakarta'
            ],
            [
                'nama' => 'SEMARANG',
                'penanggungjawab' => 'Andi Wijaya',
                'nomortelp' => '081298765432',
                'alamat' => 'Jl. Pandanaran No. 2, Semarang'
            ],
            [
                'nama' => 'SURABAYA',
                'penanggungjawab' => 'Siti Nurhaliza',
                'nomortelp' => '081345678901',
                'alamat' => 'Jl. Tunjungan No. 3, Surabaya'
            ],
            [
                'nama' => 'BANDUNG',
                'penanggungjawab' => 'Rizky Febian',
                'nomortelp' => '081456789012',
                'alamat' => 'Jl. Asia Afrika No. 4, Bandung'
            ],
        ]);
    }
}
