<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
USE Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class TachesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   

    public function index()
    {
        $taches = DB::table('taches')
            ->leftJoin('projets', 'taches.projet_id', '=', 'projets.id')
            ->leftJoin('users', 'taches.assigne_a', '=', 'users.id')
            ->select(
                'taches.id as tache_id',
                'taches.titre as tache_titre',
                'taches.description',
                'taches.statut',
                'taches.priorite',
                'projets.titre as projet_titre',
                'users.name as user_name'
            )
            ->paginate(10); 
    
        return view('taches.alltaches', compact('taches'));
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Récupérer l'utilisateur connecté
        $user = Auth::user();
    
        // Récupérer les projets créés par l'utilisateur connecté
        $projets = DB::table('projets')
                    ->where('userp_id', $user->id)  // Filtrer par l'ID de l'utilisateur qui a créé le projet
                    ->get();
    
        // Récupérer la liste des utilisateurs (si nécessaire)
        $users = DB::table('users')->get(['id', 'name']);

        // Retourner la vue avec les données
        return view('taches.taches', [
            'projets' => $projets,
            'users' => $users,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validation des données du formulaire
            $validatedData = $request->validate([
                'titre' => 'required|string|max:255',
                'description' => 'required|string',
                'projet_id' => 'required|integer|exists:projets,id',
                'priorite' => 'required|string|in:faible,moyen,urgent',
            ]);

            // Récupération de l'utilisateur connecté
            $userId = Auth::id();

            // Si l'utilisateur assigné n'est pas défini, on l'assigne à l'utilisateur connecté
            $assigne_a = $request->input('assigne_a') ?? Auth::id();


            //dd($assigne_a);
            // Création de la tâche dans la base de données
            DB::table('taches')->insert([
                'titre' => $validatedData['titre'],
                'description' => $validatedData['description'],
                'statut' => 'non commencé', // Statut par défaut
                'priorite' => $validatedData['priorite'],
                'projet_id' => $validatedData['projet_id'],
                'assigne_a' => $assigne_a,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Redirection vers la vue de création avec un message de succès
            return redirect()->route('taches.create')->with('success', 'Tâche créée avec succès.');
        } catch (\Exception $e) {
            // Gérer les erreurs et retourner à la vue avec un message d'erreur
            return redirect()->route('taches.create')->with('error', 'Erreur lors de la création de la tâche : ' . $e->getMessage());
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $userId = Auth::id();
    
        // Récupération des tâches avec filtrage et pagination
        $taches = DB::table('taches')
        ->join('projets', 'taches.projet_id', '=', 'projets.id')
        ->where(function ($query) use ($userId) {
            $query->where('taches.assigne_a', $userId)
                  ->orWhere('projets.userp_id', $userId);
        })
        ->when($request->filled('statut'), function ($query) use ($request) {
            $query->where('taches.statut', $request->statut);
        })
        ->when($request->filled('priorite'), function ($query) use ($request) {
            $query->where('taches.priorite', $request->priorite);
        })
        ->select(
            'taches.*', 
            'projets.titre as projet_titre' // Inclure le titre du projet
        )
        ->paginate(10);
    
    
        return view('taches.vutaches', compact('taches'));
    }
    
    public function editassign(Request $request)
    {
        // Récupérer l'ID de la tâche depuis le champ caché du formulaire
        $tacheId = $request->input('tache_id');
        
        // Récupérer la tâche et l'utilisateur assigné via une jointure
        $tache = DB::table('taches')
                   ->leftJoin('users', 'taches.assigne_a', '=', 'users.id')
                   ->select('taches.*', 'users.name as user_name', 'users.id as user_id')
                   ->where('taches.id', $tacheId)
                   ->first();
        
        // Vérifier si la tâche existe
        if (!$tache) {
            return redirect()->route('taches.show')->with('error', 'Tâche non trouvée.');
        }
        
        // Récupérer tous les utilisateurs pour afficher dans le formulaire de sélection
        $users = DB::table('users')->get();
    
        // Rediriger vers la page de modification de l'assignation de la tâche
        return view('taches.assign', [
            'tache' => $tache,
            'users' => $users, // Ajouter les utilisateurs à la vue
        ]);
    }

    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request) 
    {
        // Récupérer l'ID de la tâche depuis la requête
        $id = $request->input('tache_id');
    
        // Récupérer la tâche à modifier par son ID
        $tache = DB::table('taches')->where('id', $id)->first();
    
        if (!$tache) {
            // Si la tâche n'existe pas, rediriger avec un message d'erreur
            return redirect()->route('taches.show')->with('error', 'Tâche non trouvée.');
        }
    
        // Récupérer les projets et les utilisateurs pour remplir les champs de sélection
        $projets = DB::table('projets')->get(['id', 'titre']);
        $users = DB::table('users')->get(['id', 'name']);
    
        // Retourner la vue avec les données de la tâche à modifier
        return view('taches.tacheedit', [
            'tache' => $tache,
            'projets' => $projets,
            'users' => $users,
        ]);
    }
    

    public function assign(Request $request)
    {
        // Validation des données
        $request->validate([
            'user_id' => 'nullable|exists:users,id', // Assurer que l'ID utilisateur existe dans la table users
            'tache_id' => 'required|exists:taches,id', // Vérifier que la tâche existe
        ]);
    
        // Utilisation de DB pour mettre à jour l'assignation
        DB::transaction(function () use ($request) {
            // Mise à jour de l'assignation de la tâche
            DB::table('taches')
                ->where('id', $request->tache_id)
                ->update(['assigne_a' => $request->user_id]);
    
            // Si aucune assignation (utilisateur non sélectionné), on met null
            if (!$request->user_id) {
                DB::table('taches')
                    ->where('id', $request->tache_id)
                    ->update(['assigne_a' => null]);
            }
        });
    
        // Retourner à la page de la tâche avec un message de succès
        return redirect()->route('taches.show', ['tache' => $request->tache_id])
                         ->with('success', 'Assignation modifiée avec succès.');
    }
    
    
    


    public function updateStatut(Request $request)
    {
        // Validation des données de la requête
        $validatedData = $request->validate([
            'id' => 'required|integer|exists:taches,id', // ID de la tâche
        ]);
    
        try {
            // Récupérer le statut actuel de la tâche
            $tache = DB::table('taches')->where('id', $validatedData['id'])->first();
    
            if (!$tache) {
                return back()->with('error', 'La tâche n\'a pas été trouvée.');
            }
    
            $nouveauStatut = null;
    
            // Vérification du statut actuel et détermination du nouveau statut
            if ($tache->statut === 'non commencé') {
                $nouveauStatut = 'en cours';
            } elseif ($tache->statut === 'en cours') {
                $nouveauStatut = 'terminé';
            } elseif ($tache->statut === 'terminé') {
                return back()->with('error', 'La tâche est déjà terminée et son statut ne peut plus être modifié.');
            }
    
            // Si un changement de statut est déterminé, mettre à jour dans la base de données
            if ($nouveauStatut) {
                DB::table('taches')
                    ->where('id', $validatedData['id'])
                    ->update(['statut' => $nouveauStatut, 'updated_at' => now()]);
            }
    
            // Retourner avec un message de succès
            return back()->with('success', 'Le statut de la tâche a été mis à jour avec succès.');
        } catch (\Exception $e) {
            // Gérer les erreurs
            return back()->with('error', 'Une erreur est survenue lors de la mise à jour du statut.');
        }
    }
    
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // Validation des données du formulaire
        $validatedData = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'statut' => 'required|string|in:non commencé,en cours,terminé',
            'priorite' => 'required|string|in:faible,moyenne,élevée',
            'projet_id' => 'required|exists:projets,id', // Assurez-vous que le projet existe
            'assigne_a' => 'nullable|exists:users,id', // Assurez-vous que l'utilisateur existe
            'tache_id' => 'required|integer|exists:taches,id', // Vérifier que la tâche existe
        ]);
    
        // Récupérer l'ID de la tâche à mettre à jour
        $tacheId = $validatedData['tache_id'];
    
        // Utilisation d'un bloc try-catch pour gérer les erreurs
        try {
            // Récupérer la tâche à mettre à jour avec DB
            $tache = DB::table('taches')->where('id', $tacheId)->first();
    
            // Vérifier si la tâche existe
            if (!$tache) {
                return redirect()->route('taches.show')->with('error', 'Tâche non trouvée.');
            }
    
            // Mettre à jour les informations de la tâche
            DB::table('taches')->where('id', $tacheId)->update([
                'titre' => $validatedData['titre'],
                'description' => $validatedData['description'],
                'statut' => $validatedData['statut'],
                'priorite' => $validatedData['priorite'],
                'projet_id' => $validatedData['projet_id'],
                'assigne_a' => $validatedData['assigne_a'],
                'updated_at' => now(), // Mettre à jour la colonne `updated_at`
            ]);
    
            // Redirection avec un message de succès
            return redirect()->route('taches.show', $tacheId)->with('success', 'Tâche mise à jour avec succès.');
    
        } catch (\Exception $e) {
            // En cas d'erreur lors de la mise à jour
            return redirect()->route('taches.edit', $tacheId)
                             ->with('error', 'Erreur lors de la mise à jour de la tâche. Détails : ' . $e->getMessage());
        }
    }
    

    /**
     * Remove the specified resource from storage.
     */
 
    public function destroy(Request $request)
    {
        // Récupérer l'ID de la tâche depuis le formulaire
        $tacheId = $request->input('tache_id');
    
        // Récupérer la tâche pour obtenir son titre
        $tache = DB::table('taches')->where('id', $tacheId)->first();
    
        if ($tache) {
            // Supprimer la tâche via DB
            DB::table('taches')->where('id', $tacheId)->delete();
    
            // Rediriger avec le message de succès incluant le titre de la tâche
            return redirect()->route('taches.show')->with('success', 'Tâche "' . $tache->titre . '" supprimée avec succès.');
        } else {
            // Si la tâche n'est pas trouvée, rediriger avec un message d'erreur
            return redirect()->route('taches.show')->with('error', 'Impossible de trouver la tâche.');
        }
    }
    
}
