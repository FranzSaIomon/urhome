<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDocument extends Model
{
    protected $fillable = [
        "Files", "UserID"
    ];

    protected $casts = [
        "Files" => "array"
    ];

    // Relationships
    public function user() {return $this->belongsTo('App\User');}
}
