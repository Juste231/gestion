<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProjetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('projets')->insert([
            [
                'titre' => 'Projet Alpha',
                'description' => 'Description du projet Alpha.',
                'date_limite' => Carbon::now()->addDays(30)->toDateString(),
                'statut' => 'en cours',
                'userp_id' => 2, 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'titre' => 'Projet Beta',
                'description' => 'Description du projet Beta.',
                'date_limite' => Carbon::now()->addDays(60)->toDateString(),
                'statut' => 'en cours',
                'userp_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'titre' => 'Projet Gamma',
                'description' => 'Description du projet Gamma.',
                'date_limite' => Carbon::now()->addDays(45)->toDateString(),
                'statut' => 'terminé',
                'userp_id' => 2, 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'titre' => 'Projet Delta',
                'description' => 'Description du projet Delta.',
                'date_limite' => Carbon::now()->addDays(15)->toDateString(),
                'statut' => 'en cours',
                'userp_id' => 4, 
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
