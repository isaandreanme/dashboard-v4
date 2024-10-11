<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@gmail.com',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'email_verified_at' => now(),
                'is_admin' => 1,
                'is_agency' => 0,


            ],
            [
                'name' => 'Pegawai',
                'email' => 'pegawai@gmail.com',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'email_verified_at' => now(),
                'is_admin' => 1,
                'is_agency' => 0,


            ],
            [
                'name' => 'Agency',
                'email' => 'agency@gmail.com',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'email_verified_at' => now(),
                'is_admin' => 0,
                'is_agency' => 1,


            ],
            [
                'name' => 'CPMI',
                'email' => 'cpmi@gmail.com',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'email_verified_at' => now(),
                'is_admin' => 0,
                'is_agency' => 0,


            ],
        ]);
        User::factory()->count(499)->create(); // Men-generate 50 user secara otomatis

    }
}
