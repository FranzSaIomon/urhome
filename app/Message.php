<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    // Relationships
    public function user() {return $this->belongsToOne('App\User');}
}
