<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{
    protected $fillable = [
        "AmenityName"
    ];
    // Relationships
    public function property_amenity(){return $this->belongsToMany('App\PropertyAmenity');}
}
