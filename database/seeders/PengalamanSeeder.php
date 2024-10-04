<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PengalamanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pengalamen')->insert([
            [ 'nama' => 'NON'],
            [ 'nama' => 'EXS HONGKONG'],
            [ 'nama' => 'EXS TAIWAN'],
            [ 'nama' => 'EXS SINGAPURA'],
            [ 'nama' => 'EXS MALAYSIA'],
            [ 'nama' => 'EXS KOREA'],
            [ 'nama' => 'EXS JEPANG'],
            [ 'nama' => 'EXS ARAB'],
    
    
            ]);
    }
}