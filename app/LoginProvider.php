<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class LoginProvider extends Model
{
	protected $fillable = [
		'provider_user_id',
		'provider',
		'avatar'
	];

	/**
	 * returns the user associated with 
	 * this login provider
	 */
	protected function user()
	{
		return $this->belongsTo(User::class);
	}

	

}
