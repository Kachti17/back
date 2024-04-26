<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evenement extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'description',
        'image',
        'date_event',
        'lieu_event',
        'nbr_max',
        'nbr_participants',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function participants()
    {
        return $this->belongsToMany(User::class, 'participants');
    }

}
