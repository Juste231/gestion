<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projet extends Model
{
    use HasFactory;


    protected $table = 'projets';

 
    protected $fillable = [
        'titre',
        'description',
        'date_limite',
        'statut',
        'userp_id',
    ];

   
    public function utilisateur()
    {
        return $this->belongsTo(User::class, 'userp_id');
    }

    public function taches()
    {
        return $this->hasMany(Tache::class, 'projet_id');
    }
}
