<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TachesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('taches')->insert([
            // Tâches pour Projet Alpha (ID = 1)
            [
                'titre' => 'Tâche 1 pour Projet Alpha',
                'description' => 'Première tâche pour le projet Alpha.',
                'statut' => 'en cours',
                'priorite' => 'élevée',
                'projet_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'titre' => 'Tâche 2 pour Projet Alpha',
                'description' => 'Deuxième tâche pour le projet Alpha.',
                'statut' => 'terminé',
                'priorite' => 'moyenne',
                'projet_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Tâches pour Projet Beta (ID = 2)
            [
                'titre' => 'Tâche 1 pour Projet Beta',
                'description' => 'Première tâche pour le projet Beta.',
                'statut' => 'en cours',
                'priorite' => 'faible',
                'projet_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'titre' => 'Tâche 2 pour Projet Beta',
                'description' => 'Deuxième tâche pour le projet Beta.',
                'statut' => 'en cours',
                'priorite' => 'élevée',
                'projet_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Tâches pour Projet Gamma (ID = 3)
            [
                'titre' => 'Tâche 1 pour Projet Gamma',
                'description' => 'Première tâche pour le projet Gamma.',
                'statut' => 'terminé',
                'priorite' => 'moyenne',
                'projet_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'titre' => 'Tâche 2 pour Projet Gamma',
                'description' => 'Deuxième tâche pour le projet Gamma.',
                'statut' => 'en cours',
                'priorite' => 'faible',
                'projet_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Tâches pour Projet Delta (ID = 4)
            [
                'titre' => 'Tâche 1 pour Projet Delta',
                'description' => 'Première tâche pour le projet Delta.',
                'statut' => 'en cours',
                'priorite' => 'élevée',
                'projet_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'titre' => 'Tâche 2 pour Projet Delta',
                'description' => 'Deuxième tâche pour le projet Delta.',
                'statut' => 'en cours',
                'priorite' => 'moyenne',
                'projet_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
