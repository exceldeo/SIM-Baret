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
            (id, jenis_surat, mandatory)
            VALUES
            (1, 'Berita acara penelitian aset', 1),
            (2, 'Berita acara survey lapangan', 1),
            (3, 'Berita acara penaksiran aset yang diusulkan', 1),
            (4, 'Laporan hasil penaksiran harga aset Tahap IV', 1),
            (5, 'Surat pernyataan tanggung jawab nilai limit', 1),
            (6, 'Surat penetapan atas nilai limit', 1),
            (7, 'Surat pernyataan', 1),
            (8, 'Pernyataan tidak mengganggu Tupoksi dan Lampiran', 1),
            (9, 'Permohonan persetujuan penghapusan', 1),
            (10, 'Persetujuan penghapusan', 1),
            (11, 'Surat Tugas', 1),
            (12, 'Permohonan penjualan aset tindak lanjut penghapusan', 1),
            (13, 'Surat Lainnya', 0)
            "
        );
    }
}
