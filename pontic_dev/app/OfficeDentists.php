<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class OfficeDentists extends Authenticatable {

    protected $table = 'office_dentists';
    protected $fillable = [
        'id', 'office_id','name','credential','titile'
    ];
    public $timestamps = false;

}
