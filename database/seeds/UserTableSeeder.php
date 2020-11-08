<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('userdummy')->delete();
        DB::table('users')->delete();

        $pass = Hash::make('1234');
        DB::insert(
            "
            INSERT INTO users
            (nip, nama_user, unit, nama_unit, level)
            VALUES
            (?, ?, ?, ?, ?)
            ", ['05111840000117', 'Excel', 'SuperAdmin', 'INFORMATIKA', 0]);
    
        DB::insert(
            "
            INSERT INTO userdummy
            (nip, nama_user, unit)
            VALUES
            (?, ?, ?)
            ", ['05111840000053', 'Yulia', 'Admin', 1]);

        DB::insert(
            "
            INSERT INTO users
            (nip, nama_user, unit, nama_unit, level)
            VALUES
            (?, ?, ?, ?, ?)
            ", ['05111840000080', 'Zakiya', '67755450505', 'INFORMATIKA', 2]);
        
    }
}
