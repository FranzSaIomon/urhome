<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdditionalFeature extends Model
{
    protected $fillable = [
        "Name","Price"
    ];
    // Relationships
    public function transaction() {return $this->belongsToMany('App\Transaction');}
}
