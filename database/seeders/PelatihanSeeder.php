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
            [ 'nama' => 'LPKS PELATIHAN 1'],
            [ 'nama' => 'LPKS PELATIHAN 2'],
            [ 'nama' => 'LPKS PELATIHAN 3'],
            [ 'nama' => 'LPKS PELATIHAN 4'],

            ]);
    }
}
