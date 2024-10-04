<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SponsorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sponsors')->insert([
            [ 'nama' => 'OFFICE'],
            [ 'nama' => 'SPONSOR 1'],
            [ 'nama' => 'SPONSOR 2'],
            [ 'nama' => 'SPONSOR 3'],
        ]);
    }
}