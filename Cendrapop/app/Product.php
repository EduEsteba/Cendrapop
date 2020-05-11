<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Category;
use App\User;
use App\Message;
use App\ProductsImage;

class Product extends Model
{

    protected $table = 'products';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];

	protected $fillable = [
		'title', 'description', 'price', 'images', 'user_id', 'category_id'
	];


	public function images()
    {
        return $this->hasMany('App\ProductsImage');
    }

    public function messages()
    {
        return $this->hasMany('App\Message');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function category()
    {
        return $this->belongsTo('App\Category', 'category_id');
    }

}