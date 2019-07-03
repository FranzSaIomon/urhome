<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $fillable = [
        "User1", "User2"
    ];

    public function user1()
    {
        return $this->hasOne('App\User', 'id', 'User1');
    }

    public function user2() {
        return $this->hasOne('App\User', 'id', 'User2');
    }
    
    /**
     * Messages in this conversation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
