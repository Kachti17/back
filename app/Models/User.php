<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens,HasRoles;

    protected $fillable = [
        'nom', 'prenom', 'email', 'password', 'tel','img_profile',
    ];

    public function publications()
    {
        return $this->hasMany(Publication::class, 'user_id');
    }
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}