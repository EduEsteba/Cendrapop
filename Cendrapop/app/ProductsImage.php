<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Product;

/**
 * @property string file_name
 */
class ProductsImage extends Model {

	protected $table      = 'product_images';

	public    $timestamps = true;

	use SoftDeletes;

	protected $dates    = ['deleted_at'];

	protected $fillable = [
		'file_name', 'product_id'
	];

	public function images() {
		return $this->belongsTo('App\Product', 'product_id');
	}

}