<?php

namespace App;

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

    public function property() {return $this->hasMany('App\Property');}
    public function transaction() {return $this->hasOne('App\Transaction');}
    public function user_document() {return $this->hasOne('App\UserDocument');}
    public function user_type() {return $this->hasOne('App\UserType', 'id', 'UserType');} // remember dis pls
    public function message() {return $this->hasMany('App\Message');}
    public function log() {return $this->hasMany('App\Log');}
    
}
