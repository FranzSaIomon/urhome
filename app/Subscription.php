<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        "Name","Price","NumberOfUnits","Features","Period"
    ];

    protected $casts = [
        "Features" => "array"
    ];

    
    // Relationships
    public function transaction() {return $this->belongsToMany('App\Transaction');}
    public function brokers(){return $this->hasMany('App\BrokerInformation', 'SubscriptionID', 'id');}
}
