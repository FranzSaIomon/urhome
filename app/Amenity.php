<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{
    // Relationships
    public function property_amenity(){return $this->belongsToMany('App\PropertyAmenity');}
}
