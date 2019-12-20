<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;

class User extends AuthenticatableUser
{
	use Notifiable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'username', 'email', 'password',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'email_verified_at' => 'datetime',
	];

	/**
	 * Get the player files for a user
	 */
	public function playerFiles()
	{
		return $this->hasMany(PlayerFile::class);
	}

	/**
	 * Get the maximum trust for a user from all the user's player files
	 *
	 * @return integer
	 */
	public function getTrustAttribute()
	{
		return $this->playerFiles()->get()->pluck('trust')->max();
	}
}
