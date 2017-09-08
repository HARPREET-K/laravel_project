<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class UserCards extends Authenticatable {

    protected $table = 'user_cards';
    protected $fillable = [
        'id', 'user_id','card_id','cardholder_name','created_at' 
    ];
    public $timestamps = false;

}
