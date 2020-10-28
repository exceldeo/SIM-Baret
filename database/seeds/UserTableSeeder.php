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
        DB::table('users')->delete();
        $pass = Hash::make('1234');
        DB::insert(
            "
            INSERT INTO users
            (nrp, nama_user, email, password, unit, level)
            VALUES
            (?, ?, ?, ?, ?, ?)
            ", ['05111840000117', 'Excel', 'excel@gmail.com', $pass, 'SuperAdmin', 0]);
    
        DB::insert(
            "
            INSERT INTO users
            (nrp, nama_user, email, password, unit, level)
            VALUES
            (?, ?, ?, ?, ?, ?)
            ", ['05111840000053', 'Yulia', 'niza@gmail.com', $pass, 'Admin', 1]);

        DB::insert(
            "
            INSERT INTO users
            (nrp, nama_user, email, password, unit, level)
            VALUES
            (?, ?, ?, ?, ?, ?)
            ", ['05111840000080', 'Zakiya', 'zakiya@gmail.com', $pass, 'Informatika', 2]);
        DB::insert(
            "
            INSERT INTO users
            (nrp, nama_user, email, password, unit, level)
            VALUES
            (?, ?, ?, ?, ?, ?)
            ", ['05111840000080', 'Azizah', 'azizah@gmail.com', $pass, 'Kimia', 2]);
    }
}
