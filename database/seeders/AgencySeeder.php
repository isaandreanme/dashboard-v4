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
            [ 'nama' => '- BELUM MARKET'],
            [ 'nama' => '- OPEN ON MARKET'],
            [ 'nama' => 'AGENCY1'],
            [ 'nama' => 'AGENCY2'],
            [ 'nama' => 'AGENCY3'],
            [ 'nama' => 'AGENCY4'],
            [ 'nama' => 'AGENCY5'],
            [ 'nama' => 'AGENCY6'],
            [ 'nama' => 'AGENCY7'],
            [ 'nama' => 'AGENCY8'],
            [ 'nama' => 'AGENCY9'],
            [ 'nama' => 'AGENCY10'],
            [ 'nama' => 'AGENCY11'],
            [ 'nama' => 'AGENCY12'],
            [ 'nama' => 'AGENCY13'],
            [ 'nama' => 'AGENCY14'],
            [ 'nama' => 'AGENCY15'],
            [ 'nama' => 'AGENCY16'],
            [ 'nama' => 'AGENCY17'],
            [ 'nama' => 'AGENCY18'],
            [ 'nama' => 'AGENCY19'],
            [ 'nama' => 'AGENCY20'],
            
    
    
            ]);
    }
}