<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Auth\Events\Registered;

 

class User extends Authenticatable implements MustVerifyEmail
{
	use Notifiable;
	public $timestamps = false; // remove useless timestamps lol
	
    protected $table = 'login';
	public $incrementing = false;
	protected $keyType = 'string';
	protected $primaryKey = 'username';

    protected $fillable = [
        'username',
        'password',
        'email',
        'verified',
        'profilepic',
    ];
	
	protected $hidden = [
		'password',
	];
	
	protected $casts = [
		'verified' => 'boolean',
	];
	
	public function getAuthIdentifierName()
	{
		return 'username';
	}
}
