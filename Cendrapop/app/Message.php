<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Message extends Model
{

    protected $table = 'messages';
    public $timestamps = true;

	protected $fillable = [
		'user_id', 'product_id', 'content'
	];


	public function user()
    {
        return $this->belongsTo('App\Users', 'user_id');
    }

    public function product()
    {
        return $this->belongsTo('App\Product', 'product_id');
    }

}