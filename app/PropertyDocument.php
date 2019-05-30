<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyDocument extends Model
{
    protected $fillable = [
        "Images", "Files", "PropertyID"
    ];

    protected $casts = [
        "Images" => "json",
        "Files" => "array"
    ];

    public function property(){ return $this->belongsTo('App\Property', 'PropertyID', 'id');}
}
