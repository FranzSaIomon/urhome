<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $fillable = [
        "Action", "UserID"
    ];

    // Relationships
    public function user() {return $this->belongsTo('App\User');}

    public static function log($user, $msg) {
        $log = new Log();
        $log->Action = $msg;
        $log->UserID = $user;
        $log->save();
        return $log;
    }
}
