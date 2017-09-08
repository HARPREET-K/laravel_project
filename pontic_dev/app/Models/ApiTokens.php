<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ApiTokens extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'auth_token';
	protected $fillable = ['id','device_id', 'user_id', 'auth_token', 'created_at', 'updated_at'];
}

