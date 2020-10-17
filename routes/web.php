<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'Site\HomeController@index')->name('home');

Route::group(['prefix' => 'admin', 'middleware' => ['auth','acl'], 'is' => 'admin'],
    function () {
        Route::resource('books','Admin\BookController');
        Route::resource('authors','Admin\AuthorController');
        Route::resource('publishers','Admin\PublisherController');
        Route::resource('genres','Admin\GenreController');
        Route::resource('role','Admin\RoleController');
        Route::resource('info','Admin\InfoController');
        Route::resource('articles','Admin\ArticleController');
        Route::resource('tariffs','Admin\TariffController');
        Route::resource('transactions','Admin\TransactionController');
        Route::resource('videos','Admin\VideoMaterialController');
        Route::resource('banners','Admin\BannerController');
        Route::resource('supportTickets','Admin\SupportTicketController');

        Route::get('/', 'Admin\AdminPanelController@index')->name('adminPanel');
        Route::get('books', 'Admin\BookController@index')->name('booksPage');
        Route::get('articles', 'Admin\ArticleController@index')->name('articlesPage');
        Route::get('authors', 'Admin\AuthorController@index')->name('authorsPage');
        Route::get('genres', 'Admin\GenreController@index')->name('genresPage');
        Route::get('role','Admin\RoleController@index')->name('rolePage');
        Route::get('info', 'Admin\InfoController@index')->name('infoPage');
        Route::get('tariffs', 'Admin\TariffController@index')->name('tariffsPage');
        Route::get('transactions', 'Admin\TransactionController@index')->name('transactionsPage');
        Route::get('supportTickets', 'Admin\SupportTicketController@index')->name('supportTicketsPage');
        Route::get('videoMaterial', 'Admin\VideoMaterialController@index')->name('videoMaterialsPage');
        Route::get('banners', 'Admin\BannerController@index')->name('bannersPage');
        Route::get('publishers', 'Admin\PublisherController@index')->name('publishersPage');
    });
Route::get('/createAccount', 'Site\CreateAccountController@index')->name('createAccount');
Route::get('/books', 'Site\BookController@index')->name('books');
Route::get('/audioBooks', 'Site\BookController@audioBooks')->name('audioBooks');
Route::get('/articles', 'Site\ArticleController@index')->name('articles');
Route::get('/contacts', 'Site\ContactController@index')->name('contacts');
Route::get('/book/{id}', 'Site\BookController@singleBook')->name('book');
Route::get('/article/{id}', 'Site\ArticleController@singleBook')->name('article');
Route::get('/search', 'Site\SearchController@index')->name('search');
Route::get('/filter', 'Site\BookController@filter')->name('filter');
Route::get('/tariffs', 'Site\TariffController@index')->name('tariff');
Route::get('/comments/store', 'Site\CommentController@store')->name('comment');
Route::get('/profile/{id}', 'Site\ProfileController@index')->name('profile');
Route::get('/favorite', 'Site\FavoriteController@index')->name('favorite')->middleware('auth');

Route::post('favorite/{book}', 'Site\BookController@favoriteBook')->name('favoriteBook');
Route::post('unfavorite/{book}', 'Site\BookController@unFavoriteBook')->name('unfavoriteBook');
Route::get('/profile/edit/{id}', 'Site\ProfileController@edit')->name('profileEdit');
Route::post('/profile/update/{user}', 'Site\ProfileController@update')->name('updateProfile');


Route::get('/home', 'Site\HomeController@index')->name('home');

Route::get('/payment_plug/{transaction_id}', 'Site\PaymentPlug@index');
