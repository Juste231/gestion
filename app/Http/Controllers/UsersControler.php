<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersControler extends Controller
{
    /**
     * Display a listing of the resource.
     */

    
    public function index(Request $request)
    {
        // Récupérer les paramètres de recherche
        $search = $request->input('search');
    
        // Construire la requête de base
        $query = DB::table('users')
            ->select('id', 'name', 'email', 'role', 'created_at');
    
        // Appliquer la recherche si un terme est fourni
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%");
            });
        }
    
        // Ajouter la pagination
        $users = $query->paginate(10);
    
        // Retourner la vue avec les utilisateurs
        return view('user.vuuser', compact('users', 'search'));
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.creeruser');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Valider les données du formulaire
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,user', // Validation pour le rôle
        ]);
    
        // Insérer un nouvel utilisateur dans la table users
        DB::table('users')->insert([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role' => $request->input('role'), // Ajouter le rôle
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    
        return redirect()->route('users.index')->with('success', 'Utilisateur créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }
    public function updateRole(Request $request)
{
    // Valider les données reçues
    $request->validate([
        'id' => 'required|exists:users,id',
        'current_role' => 'required|in:admin,user',
    ]);

    // Déterminer le rôle cible
    $newRole = $request->current_role === 'admin' ? 'user' : 'admin';

    // Mettre à jour le rôle dans la base de données
    $updated = DB::table('users')
        ->where('id', $request->id)
        ->update(['role' => $newRole]);

    // Retourner une réponse à l'utilisateur
    if ($updated) {
        return redirect()->route('users.index')->with('success', 'Rôle mis à jour avec succès.');
    }

    return redirect()->route('users.index')->with('error', 'Échec de la mise à jour du rôle.');
}



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->input('id');
    
        // Vérifier si l'utilisateur existe
        $user = DB::table('users')->where('id', $id)->first();
    
        if (!$user) {
            return redirect()->route('users.index')->with('error', 'Utilisateur introuvable.');
        }
    
        // Supprimer l'utilisateur
        DB::table('users')->where('id', $id)->delete();
    
        return redirect()->route('users.index')->with('success', 'Utilisateur supprimé avec succès.');
    }
}
