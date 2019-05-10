<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ListingType extends Model
{
    // Relationships
    public function property() {return $this->belongsToMany('App\Property');}
}
