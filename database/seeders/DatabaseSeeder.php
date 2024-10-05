<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(IndoRegionSeeder::class);

        $this->call(AgencySeeder::class);
        $this->call(KantorSeeder::class);
        $this->call(SalesSeeder::class);
        $this->call(PengalamanSeeder::class);
        $this->call(SponsorSeeder::class);
        $this->call(StatusSeeder::class);
        $this->call(TujuanSeeder::class);
        //--------------------------------

        // $this->call(PendaftaranSeeder::class);
        // $this->call(ProsesCpmiSeeder::class);
        // $this->call(MarketingSeeder::class);



        // User::factory(10)->create();
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
