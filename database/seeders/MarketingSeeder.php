<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Marketing;
use App\Models\Pendaftaran;
use App\Models\ProsesCpmi;
use App\Models\Sales;
use App\Models\Agency;
use Faker\Factory as Faker;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class MarketingSeeder extends Seeder
{
    /**
     * Jalankan seeder database.
     */
    public function run(): void
    {
        // Inisialisasi Faker
        $faker = Faker::create();

        // Mengambil data dari tabel Pendaftaran dan ProsesCpmi
        $pendaftarans = Pendaftaran::all();
        $prosesCpmis = ProsesCpmi::all();
        $sales = Sales::all();
        $agencies = Agency::all();

        // Jika tabel pendaftaran kosong, seed beberapa data dummy
        if ($pendaftarans->isEmpty()) {
            Pendaftaran::factory()->count(5)->create();
            $pendaftarans = Pendaftaran::all();
        }

        if ($prosesCpmis->isEmpty()) {
            ProsesCpmi::factory()->count(5)->create();
            $prosesCpmis = ProsesCpmi::all();
        }

        // Jika tabel sales kosong, seed data sales
        if ($sales->isEmpty()) {
            $this->command->error('Tidak ada data di tabel Sales. Harap tambahkan data Sales terlebih dahulu.');
            return;
        }

        // Jika tabel agencies kosong, seed data agencies
        if ($agencies->isEmpty()) {
            $this->command->error('Tidak ada data di tabel Agencies. Harap tambahkan data Agencies terlebih dahulu.');
            return;
        }

        // Nama file gambar statis yang akan digunakan
        $namaFile = 'contohfotomaids.jpg';
        $direktoriFoto = 'biodata/foto';

        // Pastikan direktori penyimpanan 'biodata/foto' ada di disk 'public'
        Storage::disk('public')->makeDirectory($direktoriFoto);

        // Tentukan path file gambar di direktori 'public/images'
        $pathAsli = public_path("images/$namaFile");

        // Pastikan file gambar tersedia di lokasi asli
        if (!file_exists($pathAsli)) {
            $this->command->error("File gambar $namaFile tidak ditemukan di public/images.");
            return;
        }

        // Salin file gambar ke direktori 'storage/public/biodata/foto'
        $pathTujuan = "$direktoriFoto/$namaFile";
        Storage::disk('public')->put($pathTujuan, file_get_contents($pathAsli));

        // Membuat data Marketing berdasarkan setiap pendaftaran_id
        foreach ($pendaftarans as $pendaftaran) {
            $prosesCpmi = $prosesCpmis->random();
            $salesPerson = $sales->random();

            // Tentukan agency_id berdasarkan status_id
            $agency = null;
            if (in_array($prosesCpmi->status_id, [1, 2, 4, 5, 6])) {
                // Jika status_id adalah 1, 2, 4, 5, atau 6, pilih agency_id 1 atau 2
                $agency = $agencies->whereIn('id', [1, 2])->random();
            } elseif ($prosesCpmi->status_id === 3) {
                // Jika status_id adalah 3, pilih agency_id selain 1 dan 2
                $agency = $agencies->whereNotIn('id', [1, 2])->random();
            }

            // Tentukan nilai get_job berdasarkan status_id
            $getJob = $prosesCpmi->status_id === 3 ? true : false;

            // Membuat data Marketing
            Marketing::create([
                'pendaftaran_id' => $pendaftaran->id,
                'proses_cpmi_id' => $prosesCpmi->id,
                'sales_id' => $salesPerson->id,
                'agency_id' => $agency->id,

                // Menyimpan path gambar yang disalin ke direktori 'storage/public/biodata/foto'
                'foto' => $pathTujuan,

                // Data dummy lainnya
                'code_hk' => $faker->randomNumber(5, true),
                'code_tw' => $faker->randomNumber(5, true),
                'code_sgp' => $faker->randomNumber(5, true),
                'code_my' => $faker->randomNumber(5, true),
                'nomor_hp' => $faker->phoneNumber,
                'get_job' => $getJob, // Set nilai get_job sesuai dengan status_id
                'national' => $faker->country,
                'kelamin' => $faker->randomElement(['MALE', 'FEMALE']),
                'lulusan' => $faker->randomElement(['Elementary School', 'Junior High School', 'Senior Highschool', 'University']),
                'agama' => $faker->randomElement(['MOESLIM', 'CRISTIAN', 'HINDU', 'BOEDHA']),
                'anakke' => $faker->numberBetween(1, 5),
                'brother' => $faker->numberBetween(1, 5),
                'sister' => $faker->numberBetween(1, 5),
                'status_nikah' => $faker->randomElement(['SINGLE', 'MARRIED', 'DIVORCED', 'WIDOW']),
                'tinggi_badan' => $faker->numberBetween(150, 200),
                'berat_badan' => $faker->numberBetween(50, 100),
                'son' => $faker->randomElement(['Yes', 'No']),
                'daughter' => $faker->randomElement(['Yes', 'No']),
                'careofbabies' => $faker->randomElement(['YES', 'NO']),
                'careoftoddler' => $faker->randomElement(['YES', 'NO']),
                'careofchildren' => $faker->randomElement(['YES', 'NO']),
                'careofelderly' => $faker->randomElement(['YES', 'NO']),
                'careofdisabled' => $faker->randomElement(['YES', 'NO']),
                'careofbedridden' => $faker->randomElement(['YES', 'NO']),
                'careofpet' => $faker->randomElement(['YES', 'NO']),
                'householdworks' => $faker->randomElement(['YES', 'NO']),
                'carwashing' => $faker->randomElement(['YES', 'NO']),
                'gardening' => $faker->randomElement(['YES', 'NO']),
                'cooking' => $faker->randomElement(['YES', 'NO']),
                'driving' => $faker->randomElement(['YES', 'NO']),
                'homecountry' => $faker->numberBetween(1, 4),
                'spokenenglish' => $faker->randomElement(['POOR', 'FAIR', 'GOOD']),
                'spokencantonese' => $faker->randomElement(['POOR', 'FAIR', 'GOOD']),
                'spokenmandarin' => $faker->randomElement(['POOR', 'FAIR', 'GOOD']),
                'remark' => $faker->sentence,
                'babi' => $faker->randomElement(['YES', 'NO']),
                'liburbukanhariminggu' => $faker->randomElement(['YES', 'NO']),
                'berbagikamar' => $faker->randomElement(['YES', 'NO']),
                'takutanjing' => $faker->randomElement(['YES', 'NO']),
                'merokok' => $faker->randomElement(['YES', 'NO']),
                'alkohol' => $faker->randomElement(['YES', 'NO']),
                'pernahsakit' => $faker->randomElement(['YES', 'NO']),
                'ketsakit' => $faker->word,
                'tujuan_id' => $faker->randomDigitNotNull,
                'kantor_id' => $faker->randomDigitNotNull,
                'marketing_id' => $faker->randomDigitNotNull,
                'pengalaman_id' => $faker->randomDigitNotNull,
                'dapatjob' => $faker->randomElement(['YES', 'NO']),
                'created_at' => $pendaftaran->created_at,
                'updated_at' => now(),
            ]);
        }
    }
}
