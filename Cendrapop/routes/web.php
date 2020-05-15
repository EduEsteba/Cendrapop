<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/inici', 'ProductsController@index')->name('inici');

//Usuaris
Route::group(['middleware' => 'auth'], function () {
	Route::get('profile', 'UsersController@show')->name('profile.show');
	Route::get('profile/edit/{id}', 'UsersController@edit')->name('profile.edit');
	Route::post('profile/{id}/update', 'UsersController@update')->name('profile.update');	
	Route::get('/profile/drop/{id}', 'UsersController@destroy')->name('profile.drop');
});

//Productes
Route::get('/products/new', 'ProductsController@create')->name('products.new');
Route::post('/products/add', 'ProductsController@store')->name('products.add');
Route::get('/products/show/{id}', 'ProductsController@show')->name('products.show');
Route::get('/products/edit/{id}', 'ProductsController@edit')->name('products.edit');
Route::post('/products/{id}/update', 'ProductsController@update')->name('products.update');
Route::get('/products/drop/{id}', 'ProductsController@destroy')->name('products.drop');
Route::get('/search', 'ProductsController@search')->name('products.search');




//Categories
Route::group(['middleware' => 'admin'], function () {
	Route::get('/category/show', 'CategoriesController@index')->name('categories.show');
	Route::get('/category/new', 'CategoriesController@create')->name('categories.new');
	Route::post('/category/add', 'CategoriesController@store')->name('categories.add');
	Route::get('/category/edit/{id}', 'CategoriesController@edit')->name('categories.edit');
	Route::post('/category/{id}/update', 'CategoriesController@update')->name('categories.update');
	Route::get('/category/drop/{id}', 'CategoriesController@destroy')->name('categories.drop');
});

//Imatges
Route::get('/products/image/drop/{id}', 'ProductsImageController@destroy')->name('image.drop');
