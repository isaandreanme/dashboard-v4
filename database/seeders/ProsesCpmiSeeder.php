<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\ProsesCpmi;
use App\Models\Pendaftaran;
use App\Models\Tujuan;
use App\Models\Status;
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

        // Menentukan distribusi status yang spesifik
        $statusDistribution = array_merge(
            array_fill(0, 14, 4), // 14 entri dengan ID 4
            array_fill(0, 20, 5), // 20 entri dengan ID 5
            array_fill(0, 7, 6)   // 7 entri dengan ID 6
        );

        // Hitung jumlah sisa data yang perlu diisi secara acak
        $remainingCount = $pendaftarans->count() - count($statusDistribution);

        // Tambahkan sisa status secara acak untuk ID 1, 2, dan 3
        for ($i = 0; $i < $remainingCount; $i++) {
            $statusDistribution[] = $statuses->whereIn('id', [1, 2, 3])->random()->id;
        }

        // Acak urutan status untuk distribusi yang merata
        shuffle($statusDistribution);

        // Menambahkan data dummy untuk tabel ProsesCpmi dengan distribusi status yang telah diacak
        foreach ($pendaftarans as $index => $pendaftaran) {
            // Pilih ID tujuan secara acak dari data tujuans
            $tujuan = $tujuans->random();

            // Pilih ID status dari distribusi yang telah ditentukan
            $statusId = $statusDistribution[$index];

            // Tentukan nilai untuk tanggal berdasarkan status
            $tanggalValues = ($statusId === 3) ? [
                'tanggal_pra_bpjs' => Carbon::instance($faker->dateTimeBetween(now()->subMonths(6), now())),
                'tanggal_ujk' => Carbon::instance($faker->dateTimeBetween(now()->subMonths(6), now())),
                'tglsiapkerja' => Carbon::instance($faker->dateTimeBetween(now()->subMonths(6), now())),
                'tgl_bp2mi' => Carbon::instance($faker->dateTimeBetween(now()->subMonths(6), now())),
                'tanggal_medical_full' => Carbon::instance($faker->dateTimeBetween(now()->subMonths(6), now())),
                'tanggal_ec' => Carbon::instance($faker->dateTimeBetween(now()->subMonths(6), now())),
                'tanggal_visa' => Carbon::instance($faker->dateTimeBetween(now()->subMonths(6), now())),
                'tanggal_bpjs_purna' => Carbon::instance($faker->dateTimeBetween(now()->subMonths(6), now())),
                'tanggal_teto' => Carbon::instance($faker->dateTimeBetween(now()->subMonths(6), now())),
                'tanggal_pap' => Carbon::instance($faker->dateTimeBetween(now()->subMonths(6), now())),
                'tanggal_penerbangan' => Carbon::instance($faker->dateTimeBetween(now()->subMonths(6), now())),
                'tanggal_in_toyo' => Carbon::instance($faker->dateTimeBetween(now()->subMonths(6), now())),
                'tanggal_in_agency' => Carbon::instance($faker->dateTimeBetween(now()->subMonths(6), now())),
            ] : [
                'tanggal_pra_bpjs' => null,
                'tanggal_ujk' => null,
                'tglsiapkerja' => null,
                'tgl_bp2mi' => null,
                'tanggal_medical_full' => null,
                'tanggal_ec' => null,
                'tanggal_visa' => null,
                'tanggal_bpjs_purna' => null,
                'tanggal_teto' => null,
                'tanggal_pap' => null,
                'tanggal_penerbangan' => null,
                'tanggal_in_toyo' => null,
                'tanggal_in_agency' => null,
            ];

            ProsesCpmi::create([
                'pendaftaran_id' => $pendaftaran->id, // Menggunakan ID dari tabel Pendaftaran
                'tujuan_id' => $tujuan->id, // Menambahkan ID dari tabel Tujuans
                'status_id' => $statusId, // Menambahkan ID dari tabel Statuses
                'email_siapkerja' => $faker->unique()->safeEmail, // Menggunakan email dari Faker
                'password_siapkerja' => Hash::make('password123'), // Menggunakan hash untuk password
                'no_id_pmi' => Str::random(10), // Random string untuk nomor PMI
                'file_pp' => 'datapmi/file_pp/file.pdf', // Path file dummy, sesuaikan jika perlu
                'created_at' => $pendaftaran->created_at, // Menggunakan waktu 'created_at' dari Pendaftaran
                'updated_at' => now(),
                // Mengisi tanggal sesuai dengan kondisi
                ...$tanggalValues,
            ]);
        }
    }
}
