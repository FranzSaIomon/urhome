<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $fillable = [
        "PropertyID","Votes","Feedback"
    ];

    public function property() {return $this->belongsTo('App\Property', 'PropertyID', 'id');}

    public function get_feedback() {
        return $this->Feedback / $this->Votes;
    }
}
