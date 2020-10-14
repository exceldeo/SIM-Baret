<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(SuratTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(KomponenTableSeeder::class);
        $this->call(KategoriVolSeeder::class);

    }
}