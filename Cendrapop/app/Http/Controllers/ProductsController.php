<?php

namespace App\Http\Controllers;

use App\Category;
use App\Message;
use App\ProductsImage;
use App\Product;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

class ProductsController extends Controller {

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function create() {
		$categories = Category::pluck('title', 'id');

		return view('products.create', compact('categories'));
	}

	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store(Request $request) {

		$data      = request()->input();
		$validator = validator()->make(
			$data, [
				     'title'       => ['required', 'max:255'],
				     'description' => ['required'],
				     'price'       => ['required'],
				     'category_id' => ['required'],
				     'photo.*'     => ['image', 'mimes:jpeg,png,jpg', 'max:2048'],
			     ]
		);

		if ($validator->passes()) {
			$product = new Product(
				[
					'title'       => request()->input('title'),
					'description' => request()->input('description'),
					'price'       => request()->input('price'),
					'category_id' => request()->input('category_id'),
					'user_id'     => auth()->id(),
				]
			);
			$product->save();

			$request = app('request');

			if ($request->hasfile('images')) {

				$images = $request->images;
				foreach ($images as $image) {
					$filename = uniqid() . '.' . $image->getClientOriginalExtension();
					Image::make($image)->resize(
						500, null, function ($constraint) {
						$constraint->aspectRatio();
					}
					)->save(public_path('uploads/products/' . $filename));
					$image = new ProductsImage();
					$image->file_name = $filename;
					$image->images()->associate($product);
					$image->save();
				}
			}

			return back()->with('success', 'Producte creat correctament!');
		}

		return redirect()->back()->withErrors($validator->errors())->withInput()->with('error', 'ERROR');
	}

	

	

	

	

}
