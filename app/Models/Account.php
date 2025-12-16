<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
	public $timestamps = false; // remove useless timestamps lol

	// redundant w/ id column present
	//protected $primaryKey = 'site';
	
	public $incrementing = true;
	protected $keyType = 'int';

    protected $table = 'accounts';

    protected $fillable = [
        'site',
        'username',
        'password',
        'owner',
    ];
}
