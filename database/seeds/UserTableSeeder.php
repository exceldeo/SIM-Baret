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
