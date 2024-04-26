<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ReactionPost extends Model
{

    use HasFactory;
    protected $with = ['user','publication'];

    protected $table = 'reactions_post';
    
    protected $primaryKey = 'id';

    protected $fillable = ['pub_id', 'user_id', 'hasReaction'];
        public function publication()
    {
        return $this->belongsTo(Publication::class, 'pub_id');
    }
    public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}

public function reactions(): HasMany
    {
        return $this->hasMany(ReactionPost::class);
    }
}