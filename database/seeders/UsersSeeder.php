<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        // User::factory(10)->create();

        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin12345'), 
        ]);

        DB::table('users')->insert([
            'name' => 'Juste',
            'email' => 'juste@gmail.com',
            'password' => Hash::make('juste12345'), // Hachage du mot de passe
        ]);

        DB::table('users')->insert([
            'name' => 'Bill',
            'email' => 'bill@gmail.com',
            'password' => Hash::make('bill12345'), // Hachage du mot de passe
        ]);

        DB::table('users')->insert([
            'name' => 'Deste',
            'email' => 'deste@gmail.com',
            'password' => Hash::make('deste12345'), // Hachage du mot de passe
        ]);
    
    }
}
