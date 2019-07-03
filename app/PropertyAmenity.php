<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyAmenity extends Model
{
    protected $fillable = [
        "PropertyID", "AmenityID"
    ];
    
    // Relationships
    public function amenity() {return $this->hasOne("App\Amenity", 'id', 'AmenityID');}
    public function property() {return $this->belongsTo('App\Property', 'PropertyID', 'id');}
}
