<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SuratTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
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
            (12, 'Permohonan penjualan aset tindak lanjut penghapusan'),
            (13, 'Surat Lainnya')
            "
        );
    }
}
