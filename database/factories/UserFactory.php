<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

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
    
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement($this->femaleNames), // Mengambil nama acak dari daftar
            'email' => fake()->unique()->safeEmail(),
            'created_at' => now(),
            'email_verified_at' => now(),
            'is_admin' => 0,
            'is_agency' => 0,
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
