<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class notification extends Model
{
    use HasFactory;

    // Table associée
    protected $table = 'notifications';

    protected $fillable = [
        'message',
        'utilisateur_id',
    ];

   
    public function utilisateur()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
