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
});

//Rutes productes

Route::get('/products/new', 'ProductsController@create')->name('products.new');

//Categories
Route::group(['middleware' => 'admin'], function () {
	Route::get('/category/show', 'CategoriesController@index')->name('categories.show');
	Route::get('/category/new', 'CategoriesController@create')->name('categories.new');
	Route::post('/category/add', 'CategoriesController@store')->name('categories.add');
	Route::get('/category/edit/{id}', 'CategoriesController@edit')->name('categories.edit');
	Route::post('/category/{id}/update', 'CategoriesController@update')->name('categories.update');
	Route::get('/category/drop/{id}', 'CategoriesController@destroy')->name('categories.drop');
});