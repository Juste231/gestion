<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin12345'),
            'role' => 'admin',
        ]);

        DB::table('users')->insert([
            'name' => 'Juste',
            'email' => 'juste@gmail.com',
            'password' => Hash::make('juste12345'),
            'role' => 'user', 
        ]);

        DB::table('users')->insert([
            'name' => 'Bill',
            'email' => 'bill@gmail.com',
            'password' => Hash::make('bill12345'),
            'role' => 'user', 
        ]);

        DB::table('users')->insert([
            'name' => 'Deste',
            'email' => 'deste@gmail.com',
            'password' => Hash::make('deste12345'),
            'role' => 'user', 
        ]);
    }
}
