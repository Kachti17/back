<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Storage;


class User extends Authenticatable
{
    use HasApiTokens,HasRoles;

    protected $fillable = [
        'nom', 'prenom', 'email', 'password', 'tel','img_profile','role','departement',
    ];

    public function publications()
    {
        return $this->hasMany(Publication::class, 'user_id');
    }
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
    public function chatRooms()
{
    return $this->belongsToMany(ChatRoom::class)->withTimestamps();
}

    public function getImgProfileAttribute($value)
    {
        if($value){
            if ($this->attributes['img_profile']) {
              return asset('storage/' . $this->attributes['img_profile']);
             }
             return $this->img_profile;
        }
         return null;


    }

}