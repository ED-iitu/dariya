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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::resource('books','Admin\BookController');
Route::resource('authors','Admin\AuthorController');
Route::resource('publishers','Admin\PublisherController');
Route::resource('genres','Admin\GenreController');
Route::resource('articles','Admin\ArticleController');
Route::resource('tariffs','Admin\TariffController');
Route::resource('transactions','Admin\TransactionController');
Route::resource('videos','Admin\VideoMaterialController');
Route::resource('banners','Admin\BannerController');
Route::resource('supportTickets','Admin\SupportTicketController');

Route::get('/adminPanel', 'Admin\AdminPanelController@index')->name('adminPanel');
Route::get('/adminPanel/books', 'Admin\BookController@index')->name('booksPage');
Route::get('/adminPanel/articles', 'Admin\ArticleController@index')->name('articlesPage');
Route::get('/adminPanel/authors', 'Admin\AuthorController@index')->name('authorsPage');
Route::get('/adminPanel/genres', 'Admin\GenreController@index')->name('genresPage');
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
Route::get('/contacts', 'Site\ContactController@singleBook')->name('contacts');
Route::get('/book/{id}', 'Site\BookController@singleBook')->name('book');
Route::get('/article/{id}', 'Site\ArticleController@singleBook')->name('article');



Route::get('/home', 'Site\HomeController@index')->name('home');
