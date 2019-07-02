<?php

namespace App;

use App\Property;
use Illuminate\Database\Eloquent\Model;

class PanoramaRequest extends Model
{
    protected $fillable = [
        'PropertyID'
    ];
    
    public function property() {return $this->hasOne('App\Property', 'id', 'PropertyID');}

    public static function request($property) {
        $request = new PanoramaRequest();
        
        if (count(Property::where('id', $property)->get())) {
            $request->PropertyID = $property;
            $request->save();
        }

        return $request;
    }
}
