<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyAmenity extends Model
{
    // Relationships
    public function amenity() {return $this->hasMany("App\Amenity");}
    public function property() {return $this->belongsTo('App\Property');}
}
