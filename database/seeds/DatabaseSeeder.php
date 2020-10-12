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
            (12, 'Permohonan penjualan aset tindak lanjut penghapusan'),
            (13, 'Surat Lainnya')
            "
        );
    }

}

use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();
        $pass = Hash::make('1234');
        DB::insert(
            "
            INSERT INTO users
            (nama_user, email, password, unit, level)
            VALUES
            (?, ?, ?, ?, ?)
            ", ['Excel', 'excel@gmail.com', $pass, 'SuperAdmin', 0]);
    
        DB::insert(
            "
            INSERT INTO users
            (nama_user, email, password, unit, level)
            VALUES
            (?, ?, ?, ?, ?)
            ", ['Yulia', 'niza@gmail.com', $pass, 'Admin', 1]);

        DB::insert(
            "
            INSERT INTO users
            (nama_user, email, password, unit, level)
            VALUES
            (?, ?, ?, ?, ?)
            ", ['Zakiya', 'zakiya@gmail.com', $pass, 'Informatika', 2]);
        DB::insert(
            "
            INSERT INTO users
            (nama_user, email, password, unit, level)
            VALUES
            (?, ?, ?, ?, ?)
            ", ['Azizah', 'azizah@gmail.com', $pass, 'Kimia', 2]);
    }

}