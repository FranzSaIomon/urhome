<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    // Relationships
    public function transaction() {return $this->belongsToMany('App\Transaction');}
}
