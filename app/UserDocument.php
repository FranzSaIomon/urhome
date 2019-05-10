<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDocument extends Model
{
    protected $fillable = [
        "ImageAttachment1", "ImageAttachment2", "FileAttachment1", "FileAttachment2", "UserID"
    ];
    // Relationships
    public function user() {return $this->belongsTo('App\User');}
}
