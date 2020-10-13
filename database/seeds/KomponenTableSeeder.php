<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KomponenTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('komponen')->delete();
        DB::insert(
            "
            INSERT INTO komponen
            (id, kode_barang, nama_komponen)
            VALUES
            (1, '1234', 'Monitor'),
            (2, '1234', 'CPU'),
            (3, '1235', 'AC Indoor'),
            (4, '1235', 'AC Outdoor')
            "
        );
    }
}
