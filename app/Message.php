<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        "Message","TimeSent","TimeReceived","Receiver","Sender"
    ];
    
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'TimeSent' => 'datetime',
        'TimeReceived' => 'datetime'
    ];
    // Relationships
    public function user() {return $this->belongsToOne('App\User');}
}
