<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class UserSubscriptions extends Authenticatable {

    protected $table = 'user_subscriptions';
    protected $fillable = [
        'id', 'user_id','subscription_type','created_at','subscription_id' 
    ];
    public $timestamps = false;

}
