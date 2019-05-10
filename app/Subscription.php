<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        "Name","Price","NumberOfUnits","Features","Period"
    ];
    
    // Relationships
    public function transaction() {return $this->belongsToMany('App\Transaction');}
}
