<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TujuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tujuans')->insert([
            [ 'nama' => 'HONGKONG'],
            [ 'nama' => 'TAIWAN'],
            [ 'nama' => 'SINGAPURA'],
            [ 'nama' => 'MALAYSIA'],
            [ 'nama' => 'KOREA'],
            [ 'nama' => 'JEPANG'],
            [ 'nama' => 'ARAB'],    
    
            ]);
    }
}