<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $fillable = [
        "Status"
    ];

    // Relationships
    public function property() {return $this->belongsToMany('App\Property');}
}
