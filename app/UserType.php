<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    // Relationships
    public function user() {return $this->belongsToMany('App\User');}
}
