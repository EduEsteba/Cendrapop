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

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
	Route::get('/home', 'ProductsController@index')->name('home');
	Route::get('/shop', 'ProductsController@index')->name('shop');
	Route::get('/', 'ProductsController@index')->name('home');
});

Route::get('/condiciones','Condiciones@index')->name('condiciones');



//Usuaris
Route::group(['middleware' => 'auth'], function () {
	Route::get('profile', 'UsersController@show')->name('profile.show');
	Route::get('profile/edit/{id}', 'UsersController@edit')->name('profile.edit');
	Route::post('profile/{id}/update', 'UsersController@update')->name('profile.update');	
	Route::get('/profile/drop/{id}', 'UsersController@destroy')->name('profile.drop');
	Route::get('/profile/dropadmin/{id}', 'UsersController@destroyadmin')->name('profile.dropadmin');
});

//Productes
Route::get('/products/new', 'ProductsController@create')->name('products.new');
Route::post('/products/add', 'ProductsController@store')->name('products.add');
Route::get('/products/show/{id}', 'ProductsController@show')->name('products.show');
Route::get('/products/edit/{id}', 'ProductsController@edit')->name('products.edit');
Route::post('/products/{id}/update', 'ProductsController@update')->name('products.update');
Route::get('/products/drop/{id}', 'ProductsController@destroy')->name('products.drop');

//Categories
Route::group(['middleware' => 'admin'], function () {
	Route::get('/category/show', 'CategoriesController@index')->name('categories.show');
	Route::get('/category/new', 'CategoriesController@create')->name('categories.new');
	Route::post('/category/add', 'CategoriesController@store')->name('categories.add');
	Route::get('/category/edit/{id}', 'CategoriesController@edit')->name('categories.edit');
	Route::post('/category/{id}/update', 'CategoriesController@update')->name('categories.update');
	Route::get('/category/drop/{id}', 'CategoriesController@destroy')->name('categories.drop');
});

//Control d'usuaris
Route::group(['middleware' => 'admin'], function () {
	Route::get('/live_search', 'LiveSearch@index')->name('live_search');
	Route::get('/live_search/action', 'LiveSearch@action')->name('live_search.action');
	//JSON
	Route::get('/live_search/json', 'JsonGenerateController@json')->name('json');
	//XML
	Route::get('/users/xml','XMLController@download')->name('usuaris.xml');


});

//Control de productes
Route::group(['middleware' => 'admin'], function () {
	Route::get('/live_search_products', 'LiveSearchProducts@index')->name('live_search_products');
	Route::get('/live_search_products/action', 'LiveSearchProducts@actionproducts')->name('live_search_products.action');
	Route::get('/deleteproducts/{id}', 'ProductsController@deleteproducts')->name('products.delete');

	//JSON
	Route::get('/live_search_products/json', 'JsonGenerateController@jsonProducts')->name('products_json');
	//XML
	Route::get('/products/xml','XMLController@download_products')->name('products_xml');
});

//Imatges
Route::get('/products/image/drop/{id}', 'ProductsImageController@destroy')->name('image.drop');

//Api
Route::group(['middleware' => 'admin'], function () {
	Route::get('/users', 'ApiController@indexUsers')->name('usersapi');
	Route::get('/products', 'ApiController@indexProducts')->name('productsapi');
	Route::get('/comentaris', 'ApiController@indexComentaris')->name('comentarisapi');


});


//Comentaris

Route::group(['middleware' => 'admin'], function () {
	Route::post('/message/add', 'MessagesController@store')->name('message.add');
	Route::get('/live_search_comentaris', 'LiveSearchComentaris@index')->name('live_search_comentaris');
	Route::get('/live_search_comentaris/action', 'LiveSearchComentaris@action')->name('live_search_comentaris.action');
	Route::get('delete/{id}', 'MessagesController@destroy')->name('comentari.delete');
	//JSON
	Route::get('/live_search_missatges', 'JsonGenerateController@jsonComentaris')->name('comentaris_json');
		//XML
		Route::get('/comentaris/xml','XMLController@download_comentaris')->name('comentaris_xml');



});


