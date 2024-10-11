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
        'AMARA', 'BELLA', 'CINTA', 'DARA', 'ELENA', 'FARAH', 'GISELLE', 'HANA', 'ILMA', 'JANNA', 'KARINA', 'LUNA', 'MAIRA', 'NADA', 
        'OLIVIA', 'PUTRI', 'QUEEN', 'RANIA', 'SASKIA', 'TASYA', 'ULI', 'VIVI', 'WIDYA', 'XENA', 'YULI', 'ZAHRA', 'AMELIA', 'BELINDA', 
        'CLARA', 'DELIA', 'ELISA', 'FANI', 'GINA', 'HERA', 'INDAH', 'JENNY', 'KAYLA', 'LILA', 'MELISA', 'NIA', 'OKTA', 'PRIMA', 'QUEENA', 
        'RATIH', 'SELENA', 'TIARA', 'ULFA', 'VALERIA', 'WINA', 'XAVIERA', 'YESSICA', 'ZELDA', 'ADELIA', 'BUNGA', 'CECILIA', 'DINA', 'EKA', 
        'FITRI', 'GITA', 'HALIMA', 'IRMA', 'JASMINE', 'KEISHA', 'LANI', 'MONICA', 'NADIA', 'OKKY', 'PUSPITA', 'QIRANI', 'RISKA', 'SALMA', 
        'TANIA', 'UTAMI', 'VERA', 'WINDA', 'XANDRA', 'YUNITA', 'ZELINDA', 'ANGGITA', 'BIANCA', 'CINDY', 'DWI', 'ELVA', 'FARA', 'GRESYA', 
        'HELEN', 'IKA', 'JOANNA', 'KANIA', 'LEONITA', 'MAYA', 'NOVI', 'ORINA', 'PURNAMA', 'QONITA', 'RIRIN', 'SARI', 'TIA', 'ULINA', 
        'VENNY', 'WULANDARI', 'XIA', 'YOVITA', 'ZENIA', 'ANIS', 'BERNA', 'CHIKA', 'DEWI', 'ELLY', 'FAITH', 'GISELA', 'HANI', 'IVANA', 
        'JULIA', 'KRISNA', 'LIDYA', 'MIRNA', 'NELLY', 'OLGA', 'PRETI', 'QURRATA', 'RARA', 'SHARA', 'TITI', 'ULIANA', 'VIOLA', 'WANDA', 
        'XALINA', 'YOLA', 'ZARAH', 'AMIRA', 'BELINDA', 'CHRISTY', 'DESI', 'ERICA', 'FRIDA', 'GRENDA', 'HIDAYAH', 'INTAN', 'JANET', 
        'KURNIA', 'LAYLA', 'MONA', 'NIKE', 'OLYVIA', 'PUTI', 'QUEENTA', 'RASYA', 'SISKA', 'TALITA', 'ULVIA', 'VANYA', 'WINNIE', 'XIANA', 
        'YULIS', 'ZALINA', 'ANDINA', 'BINTANG', 'CARISSA', 'DEWI', 'ERNI', 'FADHILA', 'GINA', 'HANIA', 'ISMA', 'JENI', 'KASIA', 'LENNY', 
        'MIRA', 'NATALIA', 'ORNELLA', 'PRISKA', 'QATRUN', 'RENI', 'SILVI', 'TRISKA', 'ULFANI', 'VIOLIN', 'WULAN', 'XARA', 'YESI', 'ZURAYA', 
        'ANNISA', 'BESYA', 'CALISTA', 'DARA', 'ELIS', 'FELIS', 'GITA', 'HERMINE', 'INDA', 'JULIANA', 'KIKI', 'LILIS', 'MAISYA', 'NIARA', 
        'OCHA', 'PRILLY', 'QISMA', 'RANI', 'SHINTA', 'TRIANA', 'ULFAH', 'VELIA', 'WANDA', 'XINIA', 'YESSY', 'ZITA', 'AUREL', 'BILA', 
        'CHANDRA', 'DANTI', 'ERIKA', 'FIA', 'GRACIA', 'HELEN', 'IKA', 'JUWITA', 'KEIKO', 'LYNN', 'MARINA', 'NOVA', 'ODHILA', 'PUTI', 
        'QUINN', 'RISMA', 'SUSI', 'TANIA', 'ULIA', 'VELLA', 'WINNY', 'XARA', 'YUNITA', 'ZENA', 'ASYA', 'BRIANNA', 'CINDY', 'DIANA', 
        'ELVA', 'FARIDA', 'GENNY', 'HARINI', 'INTAN', 'JENIFER', 'KIRANA', 'LEA', 'MAYA', 'NURI', 'ONA', 'PUTRI', 'QUINTA', 'ROSI', 'SARA', 
        'TIWI', 'UMI', 'VANIA', 'WINDA', 'XIO', 'YUNITA', 'ZINA', 'ALYA', 'BETA', 'CHERLY', 'DEVI', 'ELENA', 'FARAH', 'GABY', 'HERA', 
        'IRINA', 'JUANITA', 'KARLA', 'LIANA', 'MEGA', 'NINA', 'OLEN', 'PINKA', 'QORINA', 'RINA', 'SHARON', 'TRIA', 'UTARI', 'VIVIEN', 
        'WIDYA', 'XENIA', 'YULIS', 'ZURAIDA', 'AISHA', 'BELVA', 'CLARA', 'DINI', 'EKA', 'FAHRANI', 'GINA', 'HERA', 'INDIRA', 'JULIE', 
        'KAREN', 'LISA', 'MEI', 'NINA', 'ONA', 'PUTRI', 'QUINDA', 'RATIH', 'SHINTA', 'TITA', 'ULA', 'VALERIE', 'WIDA', 'XIOMARA', 'YUSRA', 
        'ZIVA', 'ADELA', 'BINTARI', 'CELINE', 'DARA', 'ELINA', 'FANI', 'GITA', 'HANNA', 'ISHA', 'JOVITA', 'KAYLA', 'LILA', 'MELISA', 'NIA', 
        'ODI', 'PRILLA', 'QUEENY', 'RIFDA', 'SINTA', 'TIRA', 'ULYA', 'VELY', 'WITA', 'XIA', 'YULIANI', 'ZELIA', 'AMARA', 'BRILI', 'CHIKA', 
        'DIANA', 'ESTER', 'FIKA', 'GRACE', 'HERLIN', 'IKA', 'JUNA', 'KINA', 'LOUISA', 'MARIA', 'NOVA', 'OLA', 'PRITA', 'QURATU', 'RINA', 
        'SYAFA', 'TANTI', 'ULIMA', 'VIRNA', 'WURI', 'XIRA', 'YURI', 'ZANETA', 'ASTI', 'BUNGA', 'CHERYL', 'DWI', 'ELIS', 'FERA', 'GISA', 
        'HERMA', 'ISYA', 'JESSY', 'KARIN', 'LINA', 'MIRNA', 'NURUL', 'OLA', 'PUJI', 'QURROT', 'RITA', 'SALSA', 'TAMARA', 'UNI', 'VIENA', 
        'WIDIA', 'XANDRA', 'YULIS', 'ZAHRA', 'ANISA', 'BERLY', 'CHINTYA', 'DIKA', 'ERLINDA', 'FIRDA', 'GINI', 'HANI', 'IKKE', 'JULI', 
        'KRISTI', 'LINDA', 'MONIKA', 'NURMA', 'ONA', 'PRENI', 'QAYLA', 'RIANI', 'SHELLA', 'TIA', 'UMAYA', 'VINA', 'WILMA', 'XAVIER', 
        'YUNI', 'ZAHIRA'
    ];

    public function run()
    {
        $faker = Faker::create();

        // Shuffle the names array to ensure randomness
        shuffle($this->femaleNames);

        // Create 100 sample records, ensure we have at least 100 unique names
        for ($i = 0; $i < 500; $i++) {
            // Select a province with id between 31 and 35
            $province = Province::whereBetween('id', [31, 35])->inRandomOrder()->first();

            // Select a regency based on the selected province
            $regency = Regency::where('province_id', $province->id)->inRandomOrder()->first();

            // Select a district based on the selected regency
            $district = District::where('regency_id', $regency->id)->inRandomOrder()->first();

            // Select a village based on the selected district
            $village = Village::where('district_id', $district->id)->inRandomOrder()->first();
            
            static $userId = 4; // Mulai user_id dari 4

            // Insert data into the pendaftarans table
            DB::table('pendaftarans')->insert([
                'user_id' => $userId++, // Increment user_id untuk setiap data baru
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
