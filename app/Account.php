<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = ['name','email','password'];
	
	protected $hidden = ['password'];
}
