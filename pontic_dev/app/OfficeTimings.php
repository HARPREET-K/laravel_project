<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class OfficeTimings extends Authenticatable {

    protected $table = 'office_available_timings';
    protected $fillable = [
        'id', 'office_id','Mon','Tue','Wed','Thu','Fri','Sat','Sun'
    ];
    public $timestamps = false;

}
