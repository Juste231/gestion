<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Statistiques des projets
        $totalProjets = DB::table('projets')->where('userp_id', $userId)->count();
        $projetsCours = DB::table('projets')->where('userp_id', $userId)->where('statut', 'en cours')->count();
        $projetsTerm = DB::table('projets')->where('userp_id', $userId)->where('statut', 'terminé')->count();

        // Statistiques des tâches
        $totalTaches = DB::table('taches')->where('assigne_a', $userId)->count();
        $tachesCours = DB::table('taches')->where('assigne_a', $userId)->where('statut', 'en cours')->count();
        $tachesTerm = DB::table('taches')->where('assigne_a', $userId)->where('statut', 'terminé')->count();

        // Projets récents
        $projetsRecents = DB::table('projets')
            ->where('userp_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Tâches récentes
        $tachesRecentes = DB::table('taches')
            ->where('assigne_a', $userId)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard', [
            'totalProjets' => $totalProjets,
            'projetsCours' => $projetsCours,
            'projetsTerm' => $projetsTerm,
            'totalTaches' => $totalTaches,
            'tachesCours' => $tachesCours,
            'tachesTerm' => $tachesTerm,
            'projetsRecents' => $projetsRecents,
            'tachesRecentes' => $tachesRecentes
        ]);
    }
}
