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
            [ 'nama' => 'JAKARTA'],
            [ 'nama' => 'SEMARANG'],
            [ 'nama' => 'SURABAYA'],
            [ 'nama' => 'BANDUNG'],
        ]);
    }
}