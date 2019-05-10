<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyAmenity extends Model
{
    protected $fillable = [
        "PropertyID", "AmenityID"
    ];
    // Relationships
    public function amenity() {return $this->hasMany("App\Amenity");}
    public function property() {return $this->belongsTo('App\Property');}
}
