<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriVolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::insert(
            "
            INSERT INTO kategori_vol_asset
            (nama_kategori,panjang_barang,lebar_barang,tinggi_barang)
            VALUES
            ('aset kecil', '0.5', '0.5', '0.7'),
            ('aset sedang', '2', '1', '0.7'),
            ('aset besar', '2', '1', '3')
            ");
    }
}
