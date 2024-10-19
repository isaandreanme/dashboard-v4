<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PelatihanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pelatihans')->insert([
            [
                'nama' => 'LPKS PELATIHAN 1',
                'penanggungjawab' => 'John Doe',
                'nomortelp' => '081234567890',
                'alamat' => 'Jl. Pelatihan No. 1, Jakarta'
            ],
            [
                'nama' => 'LPKS PELATIHAN 2',
                'penanggungjawab' => 'Jane Doe',
                'nomortelp' => '081234567891',
                'alamat' => 'Jl. Pelatihan No. 2, Jakarta'
            ],
            [
                'nama' => 'LPKS PELATIHAN 3',
                'penanggungjawab' => 'Alice',
                'nomortelp' => '081234567892',
                'alamat' => 'Jl. Pelatihan No. 3, Jakarta'
            ],
            [
                'nama' => 'LPKS PELATIHAN 4',
                'penanggungjawab' => 'Bob',
                'nomortelp' => '081234567893',
                'alamat' => 'Jl. Pelatihan No. 4, Jakarta'
            ],
        ]);
    }
}
