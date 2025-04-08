<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            OrganizasyonSeeder::class,
            MekanSeeder::class,
            SuslemeSeeder::class,
            MenuOgeSeeder::class,
            PastaSeeder::class,
            PaketSeeder::class,
            RandevuSeeder::class,
            RezervasyonSeeder::class,
            OdemeSeeder::class,
            MekanRandevuSeeder::class,
            IletisimSeeder::class,
        ]);
    }
}
