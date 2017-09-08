<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class UserPayments extends Authenticatable {

    protected $table = 'user_payments';
    protected $fillable = [
        'id', 'user_id','payment_date','transaction_id','expiry_date','subscription_type','created_at' 
    ];
    public $timestamps = false;

}
