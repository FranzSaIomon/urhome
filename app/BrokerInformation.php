<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BrokerInformation extends Model
{
    protected $fillable = [
        "UserID","SubscriptionID","SubscriptionStart"
    ];

    public function user() {return $this->belongsTo('App\User', 'UserID', 'id');}
    public function subscription() {return $this->belongsTo('App\Subscription', 'SubscriptionID', 'id');}
    
    public function is_expired() {
        if (isset($this->SubscriptionStart) && isset($this->SubscriptionID)) {
            $time = strtotime("+" . $this->subscription->Period . " month", strtotime($this->SubscriptionStart));
            $current = time();

            if ($current > $time) {
                return true;
            }
        }
        
        return false;
    }

    public function can($i) {
        if ($this->subscription != null)
            for ($j = 0; $j < count($this->subscription->Features); $j++)
                if ($this->subscription->Features[$j] == $i)
                    return true;

        return false;
    }

    public static function toBroker($UserID) {
        $broker = BrokerInformation::where('UserID', $UserID)->first();

        if (isset($broker)) {
            return $broker;
        }

        return null;
    }
}
