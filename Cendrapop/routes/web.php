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

//Condicions i terminis
Route::get('/condiciones','Condiciones@index')->name('condiciones');

//RUTES QUE POTS ENTRAR SI ESTAS LOGIN
Route::group(['middleware' => 'auth'], function () {
	Route::get('/home', 'ProductsController@index')->name('home');
	Route::get('/shop', 'ProductsController@index')->name('shop');
	Route::get('/', 'ProductsController@index')->name('home');
	//COMENTARIS
	Route::post('/message/add', 'MessagesController@store')->name('message.add');
	//FORMULARI DE CONTACTE
	Route::get('/sendemail', 'SendEmailController@index')->name('sendemail');
	Route::post('/sendemail/send', 'SendEmailController@send');
	//USUARIS
	Route::get('profile', 'UsersController@show')->name('profile.show');
	Route::get('profile/edit/{id}', 'UsersController@edit')->name('profile.edit');
	Route::post('profile/{id}/update', 'UsersController@update')->name('profile.update');	
	Route::get('/profile/drop/{id}', 'UsersController@destroy')->name('profile.drop');
	//PRODUCTES
	Route::get('/products/new', 'ProductsController@create')->name('products.new');
	Route::post('/products/add', 'ProductsController@store')->name('products.add');
	Route::get('/products/show/{id}', 'ProductsController@show')->name('products.show');
	Route::get('/products/edit/{id}', 'ProductsController@edit')->name('products.edit');
	Route::post('/products/{id}/update', 'ProductsController@update')->name('products.update');
	Route::get('/products/image/drop/{id}', 'ProductsImageController@destroy')->name('image.drop');

});


//RUTES NOMES PER ADMIN
Route::group(['middleware' => 'auth'], function () {
	//Borrar usuaris,(no funciona, encara)
	Route::get('/profile/dropadmin/{id}', 'UsersController@destroyadmin')->name('profile.dropadmin');

	//Borrar productes,(no funciona, encara)
	Route::get('/products/drop/{id}', 'ProductsController@destroy')->name('products.drop');

	//Control de categories
	Route::get('/category/show', 'CategoriesController@index')->name('categories.show');
	Route::get('/category/new', 'CategoriesController@create')->name('categories.new');
	Route::post('/category/add', 'CategoriesController@store')->name('categories.add');
	Route::get('/category/edit/{id}', 'CategoriesController@edit')->name('categories.edit');
	Route::post('/category/{id}/update', 'CategoriesController@update')->name('categories.update');
	Route::get('/category/drop/{id}', 'CategoriesController@destroy')->name('categories.drop');

	//Control d'usuaris	
	Route::get('/live_search', 'LiveSearch@index')->name('live_search');
	Route::get('/live_search/action', 'LiveSearch@action')->name('live_search.action');
	Route::get('/deleteuser/{id}', 'UsersController@destroy')->name('userdeleteadmin');
		//Usuris JSON
		Route::get('/live_search/json', 'JsonGenerateController@json')->name('json');
		//Usuaris XML
		Route::get('/users/xml','XMLController@download')->name('usuaris.xml');

	//Control de productes
	Route::get('/live_search_products', 'LiveSearchProducts@index')->name('live_search_products');
	Route::get('/live_search_products/action', 'LiveSearchProducts@actionproducts')->name('live_search_products.action');
	Route::get('/deleteproducts/{id}', 'ProductsController@destroy')->name('products.delete');
		//Productes JSON
		Route::get('/live_search_products/json', 'JsonGenerateController@jsonProducts')->name('products_json');
		//Productes XML
		Route::get('/products/xml','XMLController@download_products')->name('products_xml');

	//Control dels comentaris
	Route::get('/live_search_comentaris', 'LiveSearchComentaris@index')->name('live_search_comentaris');
	Route::get('/live_search_comentaris/action', 'LiveSearchComentaris@action')->name('live_search_comentaris.action');
	Route::get('delete/{id}', 'MessagesController@destroy')->name('comentari.delete');
		//Productes JSON
		Route::get('/live_search_missatges', 'JsonGenerateController@jsonComentaris')->name('comentaris_json');
		//Productes XML
		Route::get('/comentaris/xml','XMLController@download_comentaris')->name('comentaris_xml');

	//API
	Route::get('/users', 'ApiController@indexUsers')->name('usersapi');
	Route::get('/products', 'ApiController@indexProducts')->name('productsapi');
	Route::get('/comentaris', 'ApiController@indexComentaris')->name('comentarisapi');
});











