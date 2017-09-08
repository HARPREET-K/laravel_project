<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class OfficeInformation extends Authenticatable {

    protected $table = 'office_information';
    protected $fillable = [
        'id', 'name', 'email', 'website', 'office_speciality', 'contact_person_name', 'job_position',
        'street', 'city', 'zipcode', 'phone_number', 'aditional_number', 'note', 'created_at', 'updated_at', 'email_notifications',
        'make_private', 'user_id'
    ];
    public $timestamps = false;

}
