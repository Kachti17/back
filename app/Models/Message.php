<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $fillable = ['corps','user_id'];


    public function sender()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function room()
    {
        return $this->hasOne('App\Models\ChatRoom','id','chat_room_id');

    }


    // public function receiver()
    // {
    //     return $this->belongsTo(User::class, 'userDes_id');
    // }

}