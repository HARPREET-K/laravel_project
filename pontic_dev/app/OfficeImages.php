<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class OfficeImages extends Authenticatable {

    protected $table = 'office_images';
    protected $fillable = [
        'id', 'office_id','image_url','create_at'
    ];
    public $timestamps = false;

}
