<?php
use Illuminate\Support\Facades\Response;
use App\User;

Route::get('/users/xml', function() {
    $users = User::all();

	$xml = new XMLWriter();
    $xml->openMemory();
    $xml->startDocument();
    $xml->startElement('users');
    foreach($users as $user) {
        $xml->startElement('data');
		$xml->writeAttribute('id', $user->id);
		$xml->writeAttribute('nom', $user->name);

		$xml->endElement();

    }
    $xml->endElement();
	$xml->endDocument();
	$filename = "xml/example.xml";
header("Content-Type: text/html/force-download");
header("Content-Disposition: attachment; filename=".$filename.".xml");


    $content = $xml->outputMemory();
	$xml = null;

    return response($content)->header('Content-Type', 'text/xml');
});

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

Route::get('/', 'HomeController@index')->name('home');
Route::get('/shop', 'ProductsController@index')->name('shop');

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
	Route::get('/live_search/json', 'JsonGenerateController@json')->name('json');

});

//Control de productes
Route::group(['middleware' => 'admin'], function () {
	Route::get('/live_search_products', 'LiveSearchProducts@index')->name('live_search_products');
	Route::get('/live_search_products/action', 'LiveSearchProducts@action')->name('live_search_products.action');
	Route::get('/live_search_products/json', 'JsonGenerateController@json')->name('json');

});

//Imatges
Route::get('/products/image/drop/{id}', 'ProductsImageController@destroy')->name('image.drop');


//Messages
Route::post('/message/add', 'MessagesController@store')->name('message.add');
