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

Route::resource('adminPanel/books','Admin\BookController');
Route::resource('adminPanel/authors','Admin\AuthorController');
Route::resource('adminPanel/publishers','Admin\PublisherController');
Route::resource('adminPanel/genres','Admin\GenreController');
Route::resource('adminPanel/info','Admin\InfoController');
Route::resource('adminPanel/articles','Admin\ArticleController');
Route::resource('adminPanel/tariffs','Admin\TariffController');
Route::resource('adminPanel/transactions','Admin\TransactionController');
Route::resource('adminPanel/videos','Admin\VideoMaterialController');
Route::resource('adminPanel/banners','Admin\BannerController');
Route::resource('adminPanel/supportTickets','Admin\SupportTicketController');

Route::get('/adminPanel', 'Admin\AdminPanelController@index')->name('adminPanel');
Route::get('/adminPanel/books', 'Admin\BookController@index')->name('booksPage');
Route::get('/adminPanel/articles', 'Admin\ArticleController@index')->name('articlesPage');
Route::get('/adminPanel/authors', 'Admin\AuthorController@index')->name('authorsPage');
Route::get('/adminPanel/genres', 'Admin\GenreController@index')->name('genresPage');
Route::get('/adminPanel/info', 'Admin\InfoController@index')->name('infoPage');
Route::get('/adminPanel/tariffs', 'Admin\TariffController@index')->name('tariffsPage');
Route::get('/adminPanel/transactions', 'Admin\TransactionController@index')->name('transactionsPage');
Route::get('/adminPanel/supportTickets', 'Admin\SupportTicketController@index')->name('supportTicketsPage');
Route::get('/adminPanel/videoMaterial', 'Admin\VideoMaterialController@index')->name('videoMaterialsPage');
Route::get('/adminPanel/banners', 'Admin\BannerController@index')->name('bannersPage');
Route::get('/adminPanel/publishers', 'Admin\PublisherController@index')->name('publishersPage');
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



Route::get('/home', 'Site\HomeController@index')->name('home');

Route::get('/payment_plug/{transaction_id}', 'Site\PaymentPlug@index');
