<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    // Relationships
    public function property() {return $this->belongsToMany('App\Property');}
}
