<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contenu extends Model
{
    use HasFactory;

    protected $fillable = [
         'texte', 'image_path', 'video_path', 'lien'
    ];
    public function getImagePathAttribute($value)
    {
        if($value){
            if ($this->attributes['image_path']) {
              return asset('storage/' . $this->attributes['image_path']);
             }
             return $this->image_path;
        }
         return null;


    }
    // public function getVideoPathAttribute($value)
    // {
    //     if($value){
    //         if ($this->attributes['video_path']) {
    //           return asset('storage/' . $this->attributes['video_path']);
    //          }
    //          return $this->video_path;
    //     }
    //      return null;


    // }

}
