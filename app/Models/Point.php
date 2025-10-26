<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    protected $fillable =  [
        'latitud',
        'longitud',
        'tipo',
        'descripcion',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
