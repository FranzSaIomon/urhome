<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDocument extends Model
{
    // Relationships
    public function user() {return $this->belongsTo('App\User');}
}
