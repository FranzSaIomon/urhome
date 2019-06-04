<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{
    protected $fillable = [
        "AmenityName"
    ];
    
    // Relationships
    public function property_amenity(){return $this->hasMany('App\PropertyAmenity', 'AmenityID', 'id');}
    public function property(){return $this->hasManyThrough('App\Property', 'App\PropertyAmenity', 'PropertyID', 'id');}
}
