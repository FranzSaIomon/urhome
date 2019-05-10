<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        "Message","TimeSent","TimeReceived","Receiver","Sender"
    ];
    
    // Relationships
    public function user() {return $this->belongsToOne('App\User');}
}
