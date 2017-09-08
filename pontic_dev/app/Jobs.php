<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Jobs extends Authenticatable {

    protected $table = 'jobs';
    protected $fillable = [
        'id','office_id', 'type_id','date','start_time','end_time','hourly_rate','estimated_cost','description','is_completed','create_at','updated_at'
    ];
    public $timestamps = false;

}
