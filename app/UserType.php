<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    protected $fillable = [
        "UserType"
    ];
    // Relationships
    public function user() {return $this->belongsToMany('App\User');}
}
