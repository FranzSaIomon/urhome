<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDocument extends Model
{
    protected $fillable = [
        "Images", "Files", "UserID"
    ];

    protected $casts = [
        "Images" => "array",
        "Files" => "array"
    ];

    // Relationships
    public function user() {return $this->belongsTo('App\User');}
}
