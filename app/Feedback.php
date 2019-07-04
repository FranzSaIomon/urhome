<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $fillable = [
        "PropertyID","UserID","Feedback"
    ];

    public function property() {return $this->belongsTo('App\Property', 'PropertyID', 'id');}
    public function user() {return $this->belongsTo('App\User', 'UserID', 'id');}
}
