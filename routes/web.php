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

Route::get('/adminPanel', 'Admin\AdminPanelController@index')->name('adminPanel')->middleware();
Route::get('/adminPanel/books', 'Admin\BookController@index')->name('booksPage');
Route::get('/adminPanel/articles', 'Admin\ArticleController@index')->name('articlesPage');
Route::get('/adminPanel/authors', 'Admin\AuthorController@index')->name('authorsPage');
Route::get('/adminPanel/genres', 'Admin\GenreController@index')->name('genresPage');
Route::get('/adminPanel/tariffs', 'Admin\TariffController@index')->name('tariffsPage');
Route::get('/adminPanel/transactions', 'Admin\TransactionController@index')->name('transactionsPage');
Route::get('/adminPanel/supportTickets', 'Admin\SupportTicketController@index')->name('supportTicketsPage');
Route::get('/adminPanel/videoMaterials', 'Admin\VideoMaterialController@index')->name('videoMaterialsPage');
Route::get('/adminPanel/banners', 'Admin\BannerController@index')->name('bannersPage');
Route::get('/adminPanel/publishers', 'Admin\PublisherController@index')->name('publishersPage');



Route::get('/home', 'HomeController@index')->name('home');
