<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commentaire extends Model
{
    use HasFactory;
    protected $with = ['user'];

    protected $fillable = [
        'contenu_comm', 'date_comm',
    ];

    public function publication()
    {
        return $this->belongsTo(Publication::class, 'pub_id');
    }
    public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}
}