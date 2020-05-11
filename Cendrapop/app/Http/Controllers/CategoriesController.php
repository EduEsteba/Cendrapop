<?php

namespace App\Http\Controllers;

use App\Product;
use App\User;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

class CategoriesController extends Controller {

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index() {
		$categories = Category::with('products')->get();

		return view('categories.show', compact('categories'));
	}

	/**
	 * @param array $data
	 *
	 * @return \Illuminate\Contracts\Validation\Validator|\Illuminate\Validation\Validator
	 */
	public function validator(array $data) {
		return Validator::make(
			$data, [
				     'title' => ['required', 'string', 'max:255'],
			     ]
		);
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function create() {
		return view('categories.create');
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
				     'title' => ['required', 'string', 'max:255'],
			     ]
		);

		if ($validator->passes()) {

			$request  = app('request');
			$filename = '';

			$category = new Category(
				[
					'title' => request()->input('title'),
				]
			);

			$category->save();

			return redirect(route('categories.show'))->with('success', 'Categoria creada correctament!');
		}

		return redirect()->back()->withErrors($validator->errors())->withInput()->with('error', 'ERROR!');
	}

	/**
	 * @param $id
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function edit($id) {
		$category = Category::find($id);

		return view('categories.edit', compact('category'));
	}

	/**
	 * @param $id
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update(Request $request, $id) {

		$data      = request()->input();
		$validator = validator()->make(
			$data, [
				     'title' => ['required', 'string', 'max:255'],
			     ]
		);

		if ($validator->passes()) {
			$category        = Category::find($id);
			$category->title = $request->get('title');
			$category->save();

			return redirect(route('categories.show'))->with('success', 'Categoria editada correctament!');
		}

		return redirect()->back()->withErrors($validator->errors())->withInput()->with('error', 'ERROR!');
	}

	public function destroy($id) {
		$category = Category::find($id);
		$category->delete();
		return redirect(route('categories.show'))->with('success', 'Category ' . $category->title . ' Deleted!');
	}

}

