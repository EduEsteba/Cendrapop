<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Intervention\Image\Facades\Image;

class RegisterController extends Controller {
	/*
	|--------------------------------------------------------------------------
	| Register Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users as well as their
	| validation and creation. By default this controller uses a trait to
	| provide this functionality without requiring any additional code.
	|
	*/

	use RegistersUsers;

	/**
	 * Where to redirect users after registration.
	 *
	 * @var string
	 */
	protected $redirectTo = '/';

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware('guest');
	}

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array $data
	 *
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	protected function validator(array $data) {
		return Validator::make(
			$data, [
				     'name'     => ['required', 'string', 'max:255'],
				     'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
				     'password' => ['required', 'string', 'min:6', 'confirmed'],
				     'photo'    => ['image', 'mimes:jpeg,png,jpg', 'max:2048'],
			     ]
		);
	}

	protected function create(array $data) {

		$request = app('request');

		if ($request->hasfile('photo')) {
			$photo    = $request->file('photo');
			$filename = time() . '.' . $photo->getClientOriginalExtension();
			Image::make($photo)->resize(
				300, null, function ($constraint) {
				$constraint->aspectRatio();
			}
			)->save(public_path('/uploads/users/' . $filename));
		}

		return User::create(
			[
				'name'     => $data['name'],
				'email'    => $data['email'],
				'password' => Hash::make($data['password']),
				'photo'    => $filename,
				'type'     => User::DEFAULT_ROLE,
			]
		);
	}
}
