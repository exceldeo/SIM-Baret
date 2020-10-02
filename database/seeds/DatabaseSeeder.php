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
        $this->call('JenisSuratSeeder');
    }
}

use Illuminate\Support\Facades\DB;

class JenisSuratSeeder extends Seeder {

    public function run()
    {
        DB::table('jenis_surat')->delete();
        DB::insert(
            "
            INSERT INTO jenis_surat
            (id, jenis_surat)
            VALUES
            (1, 'Pernyataan tidak mengganggu Tupoksi'),
            (2, 'Permohonan persetujuan penghapusan'),
            (3, 'Persetujuan penghapusan')
            ");
    }

}
