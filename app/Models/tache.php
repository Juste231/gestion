<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tache extends Model
{
    use HasFactory;

    protected $table = 'taches';

    protected $fillable = [
        'titre',
        'description',
        'statut',
        'priorite',
        'projet_id',
        'assigne_a',
    ];


    public function projet()
    {
        return $this->belongsTo(Projet::class, 'projet_id');
    }

    public function assigneA()
    {
        return $this->belongsTo(User::class, 'assigne_a');
    }
}
