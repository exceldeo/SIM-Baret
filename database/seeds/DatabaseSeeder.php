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
        $this->call('UserSeeder');
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
            (1, 'Berita acara penelitian aset'),
            (2, 'Berita acara survey lapangan'),
            (3, 'Berita acara penaksiran aset yang diusulkan'),
            (4, 'Laporan hasil penaksiran harga aset Tahap IV'),
            (5, 'Surat pernyataan tanggung jawab nilai limit'),
            (6, 'Surat penetapan atas nilai limit'),
            (7, 'Surat pernyataan'),
            (8, 'Pernyataan tidak mengganggu Tupoksi'),
            (9, 'Permohonan persetujuan penghapusan'),
            (10, 'Persetujuan penghapusan'),
            (11, 'Surat Tugas'),
            (12, 'Permohonan penjualan aset tindak lanjut penghapusan')
            ");
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

use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();
        $pass = Hash::make('bambangganteng');
        DB::insert(
            "
            INSERT INTO users
            (nama_user, email, password, unit, level)
            VALUES
            (?, ?, ?, ?, ?)
            ", ['Bambang', 'bambang@bambangmail.com', $pass, 'Perbambangan', 0]);
    }

}