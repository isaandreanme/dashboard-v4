<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\ProsesCpmi;
use App\Models\Pendaftaran;
use App\Models\Tujuan; // Import model Tujuan
use App\Models\Status; // Import model Status
use Faker\Factory as Faker;
use Carbon\Carbon;

class ProsesCpmiSeeder extends Seeder
{
    public function run()
    {
        // Inisialisasi Faker
        $faker = Faker::create();

        // Mendapatkan beberapa entri dari tabel Pendaftaran untuk referensi
        $pendaftarans = Pendaftaran::all();

        // Mendapatkan semua data dari tabel Tujuans
        $tujuans = Tujuan::all();

        // Mendapatkan semua data dari tabel Statuses
        $statuses = Status::all();

        // Jika tidak ada data pendaftaran, buat beberapa entri dummy
        if ($pendaftarans->isEmpty()) {
            Pendaftaran::factory()->count(5)->create();
            $pendaftarans = Pendaftaran::all();
        }

        // Jika tabel Tujuans kosong, tampilkan pesan kesalahan atau logika alternatif
        if ($tujuans->isEmpty()) {
            $this->command->error('Tidak ada data di tabel Tujuans. Harap tambahkan data Tujuans terlebih dahulu.');
            return;
        }

        // Jika tabel Statuses kosong, tampilkan pesan kesalahan atau logika alternatif
        if ($statuses->isEmpty()) {
            $this->command->error('Tidak ada data di tabel Statuses. Harap tambahkan data Statuses terlebih dahulu.');
            return;
        }

        // Menambahkan data dummy untuk tabel ProsesCpmi
        foreach ($pendaftarans as $pendaftaran) {
            // Pilih ID tujuan secara acak dari data tujuans
            $tujuan = $tujuans->random();

            // Pilih ID status secara acak dari data statuses
            $status = $statuses->random();

            ProsesCpmi::create([
                'pendaftaran_id' => $pendaftaran->id, // Menggunakan ID dari tabel Pendaftaran
                'tujuan_id' => $tujuan->id, // Menambahkan ID dari tabel Tujuans
                'status_id' => $status->id, // Menambahkan ID dari tabel Statuses
                'tanggal_pra_bpjs' => Carbon::instance($faker->dateTimeBetween(now()->subMonths(6), now())),
                'tanggal_ujk' => Carbon::instance($faker->dateTimeBetween(now()->subMonths(6), now())),
                'tglsiapkerja' => Carbon::instance($faker->dateTimeBetween(now()->subMonths(6), now())),
                'email_siapkerja' => $faker->unique()->safeEmail, // Menggunakan email dari Faker
                'password_siapkerja' => Hash::make('password123'), // Menggunakan hash untuk password
                'tgl_bp2mi'=> Carbon::instance($faker->dateTimeBetween(now()->subMonths(6), now())),
                'no_id_pmi' => Str::random(10), // Random string untuk nomor PMI
                'file_pp' => 'datapmi/file_pp/file.pdf', // Path file dummy, sesuaikan jika perlu
                'tanggal_medical_full' => Carbon::instance($faker->dateTimeBetween(now()->subMonths(6), now())),
                'tanggal_ec' => Carbon::instance($faker->dateTimeBetween(now()->subMonths(6), now())),
                'tanggal_visa' => Carbon::instance($faker->dateTimeBetween(now()->subMonths(6), now())),
                'tanggal_bpjs_purna' => Carbon::instance($faker->dateTimeBetween(now()->subMonths(6), now())),
                'tanggal_teto' => Carbon::instance($faker->dateTimeBetween(now()->subMonths(6), now())),
                'tanggal_pap' => Carbon::instance($faker->dateTimeBetween(now()->subMonths(6), now())),
                'tanggal_penerbangan' => Carbon::instance($faker->dateTimeBetween(now()->subMonths(6), now())),
                'tanggal_in_toyo' => Carbon::instance($faker->dateTimeBetween(now()->subMonths(6), now())),
                'tanggal_in_agency' => Carbon::instance($faker->dateTimeBetween(now()->subMonths(6), now())),
                'created_at' => $pendaftaran->created_at, // Menggunakan waktu 'created_at' dari Pendaftaran
                'updated_at' => now(),
            ]);
        }
    }
}
