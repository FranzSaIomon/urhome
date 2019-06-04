<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ListingType extends Model
{
    protected $fillable = [
        "ListingType"
    ];
    
    // Relationships
    public function property() {return $this->belongsToMany('App\Property');}
}
