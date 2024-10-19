<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AgencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('agencies')->insert([
            [
                'nama' => '- BELUM MARKET',
                'penanggungjawab' => 'John Doe',
                'nomortelp' => '081234567890',
                'alamat' => 'Jl. Contoh No. 1, Jakarta'
            ],
            [
                'nama' => '- OPEN ON MARKET',
                'penanggungjawab' => 'Jane Doe',
                'nomortelp' => '081234567891',
                'alamat' => 'Jl. Contoh No. 2, Jakarta'
            ],
            [
                'nama' => 'AGENCY1',
                'penanggungjawab' => 'Alice',
                'nomortelp' => '081234567892',
                'alamat' => 'Jl. Contoh No. 3, Jakarta'
            ],
            [
                'nama' => 'AGENCY2',
                'penanggungjawab' => 'Bob',
                'nomortelp' => '081234567893',
                'alamat' => 'Jl. Contoh No. 4, Jakarta'
            ],
            [
                'nama' => 'AGENCY3',
                'penanggungjawab' => 'Charlie',
                'nomortelp' => '081234567894',
                'alamat' => 'Jl. Contoh No. 5, Jakarta'
            ],
            [
                'nama' => 'AGENCY4',
                'penanggungjawab' => 'David',
                'nomortelp' => '081234567895',
                'alamat' => 'Jl. Contoh No. 6, Jakarta'
            ],
            [
                'nama' => 'AGENCY5',
                'penanggungjawab' => 'Eve',
                'nomortelp' => '081234567896',
                'alamat' => 'Jl. Contoh No. 7, Jakarta'
            ],
            [
                'nama' => 'AGENCY6',
                'penanggungjawab' => 'Frank',
                'nomortelp' => '081234567897',
                'alamat' => 'Jl. Contoh No. 8, Jakarta'
            ],
            [
                'nama' => 'AGENCY7',
                'penanggungjawab' => 'Grace',
                'nomortelp' => '081234567898',
                'alamat' => 'Jl. Contoh No. 9, Jakarta'
            ],
            [
                'nama' => 'AGENCY8',
                'penanggungjawab' => 'Heidi',
                'nomortelp' => '081234567899',
                'alamat' => 'Jl. Contoh No. 10, Jakarta'
            ],
            [
                'nama' => 'AGENCY9',
                'penanggungjawab' => 'Ivy',
                'nomortelp' => '081234567900',
                'alamat' => 'Jl. Contoh No. 11, Jakarta'
            ],
            [
                'nama' => 'AGENCY10',
                'penanggungjawab' => 'Jack',
                'nomortelp' => '081234567901',
                'alamat' => 'Jl. Contoh No. 12, Jakarta'
            ],
        ]);
    }
}
