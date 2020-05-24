<?php

namespace App;
use App\Product;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable 
{
    use Notifiable;
    protected $table = 'users';   
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'username', 'password', 'photo'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    const ADMIN_ROLE = 'admin';
	const DEFAULT_ROLE = 'default';

	public function isAdmin()    {

		if ($this->role === self::ADMIN_ROLE) {
			return true;
		}
		return false;
	}

	public function products()
	{
		return $this->hasMany('App\Product');
	}
}
