<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProjetsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('projets.projects');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation des données du formulaire
        $validatedData = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'date_limite' => 'required|date|after:today',
            'statut' => 'required|string|in:en cours,terminé,annulé',
        ]);

        try {
            // Récupérer l'utilisateur connecté
            $userId = Auth::id();

            // Insertion des données dans la table 'projets'
            $projetId = DB::table('projets')->insertGetId([
                'titre' => $validatedData['titre'],
                'description' => $validatedData['description'],
                'date_limite' => $validatedData['date_limite'],
                'statut' => $validatedData['statut'],
                'userp_id' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Retourner un message de succès à la même page avec les anciennes entrées
            return back()->with('success', 'Projet créé avec succès!');
        } catch (\Exception $e) {
            // En cas d'erreur lors de l'insertion
            return back()->with('error', 'Une erreur s\'est produite lors de la création du projet : ' . $e->getMessage());
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $userId = Auth::id();
    
        // Récupérer les paramètres de recherche et de filtrage
        $search = $request->input('search');
        $statut = $request->input('statut');
    
        // Construction de la requête
        $query = DB::table('projets')->where('userp_id', $userId);
    
        // Filtrage par titre (recherche)
        if ($search) {
            $query->where('titre', 'like', "%{$search}%");
        }
    
        // Filtrage par statut
        if ($statut) {
            $query->where('statut', $statut);
        }
    
        // Pagination avec les résultats filtrés
        $projets = $query->paginate(10);
    
        return view('projets.vuprojets', compact('projets'));
    }
    
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        // Validation de l'ID passé dans la requête
        $validatedData = $request->validate([
            'id' => 'required|integer|exists:projets,id', // ID obligatoire et doit exister dans la table projets
        ]);
    
        // Récupérer l'ID du projet
        $projetId = $validatedData['id'];
    
        // Récupérer les informations du projet
        $projet = DB::table('projets')->where('id', $projetId)->first();
    
        // Vérifier si le projet existe (cette étape est redondante grâce à la validation)
        if (!$projet) {
            return redirect()->route('projets.show')->with('error', 'Projet non trouvé.');
        }
    
        // Retourner la vue avec les informations du projet
        return view('projets.projetsedit', compact('projet'));
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
{
    // Validation des données du formulaire
    $validatedData = $request->validate([
        'titre' => 'required|string|max:255',
        'description' => 'required|string',
        'date_limite' => 'required|date|after:today',
        'statut' => 'required|string|in:en cours,terminé',
        'id' => 'required|integer|exists:projets,id', // L'ID est récupéré dans la requête
    ]);

    // Récupérer l'ID du projet à mettre à jour
    $projetId = $validatedData['id'];

    // Utilisation d'un bloc try-catch pour gérer les erreurs
    try {
        // Récupérer le projet à mettre à jour avec DB
        $projet = DB::table('projets')->where('id', $projetId)->first();

        // Vérifier si le projet existe
        if (!$projet) {
            return redirect()->route('projets.show')->with('error', 'Projet non trouvé.');
        }

        // Mettre à jour les informations du projet
        DB::table('projets')->where('id', $projetId)->update([
            'titre' => $validatedData['titre'],
            'description' => $validatedData['description'],
            'date_limite' => $validatedData['date_limite'],
            'statut' => $validatedData['statut'],
            'updated_at' => now(), // Mettre à jour la colonne `updated_at`
        ]);

        // Redirection avec un message de succès
        return redirect()->route('projets.show')->with('success', 'Projet mis à jour avec succès.');

    } catch (\Exception $e) {
        // En cas d'erreur lors de la mise à jour
        return redirect()->route('projets.edit', $projetId)
                         ->with('error', 'Erreur lors de la mise à jour du projet. Détails : ' . $e->getMessage());
    }
}

    

    public function updateStatus(Request $request)
    {
        try {
            // Utilisation de DB pour trouver et mettre à jour le projet
            $projetId = $request->input('id');
            $newStatus = $request->input('status');
    
            // Validation du statut
            if (!in_array($newStatus, ['en cours', 'terminé'])) {
                return redirect()->route('projets.show')->with('error', 'Statut invalide.');
            }
    
            // Mise à jour via DB
            $updated = DB::table('projets')
                        ->where('id', $projetId)
                        ->update(['statut' => $newStatus]);
    
            // Vérification si la mise à jour a réussi
            if ($updated) {
                return redirect()->route('projets.show')->with('success', 'Statut mis à jour avec succès.');
            }
    
            // Si aucune ligne n'a été mise à jour
            return redirect()->route('projets.show')->with('error', 'Aucun projet trouvé ou statut déjà mis à jour.');
            
        } catch (\Exception $e) {
            // En cas d'erreur
            return redirect()->route('projets.show')->with('error', 'Erreur lors de la mise à jour du statut.');
        }
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            // Trouver l'ID du projet à supprimer
            $projetId = $request->id;
    
   
            $projet = DB::table('projets')->where('id', $projetId)->first();

            DB::table('projets')->where('id', $projetId)->delete();
    
            // Message de succès
            return redirect()->route('projets.show')->with('success', 'Le projet "' . $projet->titre . '" a été supprimé avec succès.');
        } catch (\Exception $e) {
            // Message d'erreur en cas d'échec
            return redirect()->route('projets.show')->with('error', 'Une erreur est survenue lors de la suppression du projet.');
        }
    }
}
