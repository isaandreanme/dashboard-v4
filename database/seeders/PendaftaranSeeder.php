<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Faker\Factory as Faker;
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;

class PendaftaranSeeder extends Seeder
{
    // List of Indonesian female names
    private $femaleNames = [
        'AYU LESTARI', 'ANISA PUTRI', 'DEWI SARI', 'SITI NURHALIZA', 'FITRI AMALIA', 'PUTRI AYU', 
        'RINA SAFITRI', 'WULAN DEWI', 'LESTARI ANGGRAINI', 'RINI PUSPITA', 'SRI WAHYUNI', 
        'NISA RAHMAWATI', 'ROSA FEBRIANTI', 'INTAN PERMATASARI', 'DESI NATALIA', 'YULI KARTIKA',
        // (list continues...)
    ];

    public function run()
    {
        $faker = Faker::create();

        // Shuffle the names array to ensure randomness
        shuffle($this->femaleNames);

        // Create 100 sample records, ensure we have at least 100 unique names
        for ($i = 0; $i < 100; $i++) {
            // Select a province with id between 31 and 35
            $province = Province::whereBetween('id', [31, 35])->inRandomOrder()->first();

            // Select a regency based on the selected province
            $regency = Regency::where('province_id', $province->id)->inRandomOrder()->first();

            // Select a district based on the selected regency
            $district = District::where('regency_id', $regency->id)->inRandomOrder()->first();

            // Select a village based on the selected district
            $village = Village::where('district_id', $district->id)->inRandomOrder()->first();

            // Insert data into the pendaftarans table
            DB::table('pendaftarans')->insert([
                'nama' => $this->uniqueFemaleName($i),
                'nomor_ktp' => $faker->numerify('3324############'),
                'tempat_lahir' => $faker->randomElement(['KENDAL', 'BATANG', 'SEMARANG', 'BREBES', 'PATI']),
                'tgl_lahir' => $faker->dateTimeBetween('1988-01-01', '1999-12-31')->format('Y-m-d'),
                'nomor_telp' => $faker->numerify('08#########'),
                'nomor_kk' => $faker->numerify('3324############'),
                'nama_wali' => $faker->name,
                'nomor_ktp_wali' => $faker->numerify('3324############'),
                'kantor_id' => $faker->numberBetween(1, 4),
                'sponsor_id' => $faker->numberBetween(1, 4),
                'tujuan_id' => $faker->numberBetween(1, 4),
                'pengalaman_id' => $faker->numberBetween(1, 5),
                'alamat' => $faker->address,
                'rtrw' => $faker->bothify('###/###'),
                'province_id' => $province->id, // Only provinces with ID between 31 and 35
                'regency_id' => $regency->id,   // Matching regency
                'district_id' => $district->id, // Matching district
                'village_id' => $village->id,   // Matching village
                'tanggal_pra_medical' => Carbon::instance($faker->dateTimeBetween(now()->subMonths(6), now())),
                'pra_medical' => $faker->randomElement(['FIT', 'UNFIT']),
                'data_lengkap' => $faker->boolean,
                'created_at' => Carbon::instance($faker->dateTimeBetween(now()->subMonths(6), now())),
                'updated_at' => now(),
            ]);
        }
    }

    private function uniqueFemaleName($index)
    {
        // Make sure the index is within bounds
        if ($index < count($this->femaleNames)) {
            return $this->femaleNames[$index];
        }
        // Fallback to a random name if index is out of bounds
        return $this->femaleNames[array_rand($this->femaleNames)];
    }

    private function fakeFilePath($fileType)
    {
        // Mock file path, adjust to match how files are handled in your app
        return 'pendaftaran/' . $fileType . '/' . Str::random(10) . '.jpg';
    }
}
