<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    protected $fillable = [
        'user_id',
        'evenement_id',
        'inscription_date',
        // Ajoutez d'autres colonnes si nécessaire
    ];

    protected $dates = [
        'inscription_date',
    ];

    // Définition des relations avec d'autres modèles
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function evenement()
    {
        return $this->belongsTo(Evenement::class);
    }
}
