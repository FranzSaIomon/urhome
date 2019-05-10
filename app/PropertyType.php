<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyType extends Model
{
    // Relationships
    public function property() {return $this->belongsToMany('App\Property');}
}
