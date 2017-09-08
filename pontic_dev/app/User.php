<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
  protected $table = 'users';
  protected $fillable = [
        'id', 'name', 'email', 'password', 'userType', 'remember_token', 'activated', 'profile_image', 'title', 'user_type_id', 'experience', 'expected_pay', 'state_license', 'mobile_number', 'aditional_number', 'street', 'city', 'state', 'zipcode', 'user_note', 'email_notifications', 'make_private','user_note','contact_email', 'created_at', 'updated_at','travel_distance','malpractice_insurance','expiry_date','package_type','is_payment_enabled','stripe_customer_id'
    ];
    
    
	public $timestamps = false;
}
