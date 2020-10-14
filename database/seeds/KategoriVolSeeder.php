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
            ('aset kecil', '1', '1', '1'),
            ('aset sedang', '5', '5', '5'),
            ('aset besar', '10', '10', '10')
            ");
    }
}
