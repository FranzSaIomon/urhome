<?php

namespace App;

use App\Feedback;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'FirstName', 'LastName', 'ContactNo', 'BirthDate', 'LotNo',
        'Street', 'City', 'Country', 'Status', 'ProfileImage', 'UserType', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function has_voted($property_id) {
        if (Feedback::where("UserID", $this->id)->where("PropertyID", $property_id)->first() == null)
            return false;
        
        return true;
    }

    public function property() {return $this->hasMany('App\Property', 'UserID', 'id');}
    public function transaction() {return $this->hasOne('App\Transaction', 'UserID', 'id');}
    public function user_document() {return $this->hasOne('App\UserDocument', 'UserID', 'id');}
    public function user_type() {return $this->hasOne('App\UserType', 'id', 'UserType');}
    public function log() {return $this->hasMany('App\Log', 'UserID', 'id');}
    public function feedback() {return $this->hasMany('App\Feedback', 'UserID', 'id');}
    public function broker_information() {return $this->hasOne('App\BrokerInformation', 'UserID', 'id');}
}
