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
        Route::resource('categories','Admin\CategoryController');
        Route::resource('invite_to_vip','Admin\InviteToVipController');
        Route::resource('users','Admin\UserController');
        Route::resource('role','Admin\RoleController');
        Route::resource('info','Admin\InfoController');
        Route::resource('page','Admin\PageController');
        Route::resource('articles','Admin\ArticleController');
        Route::resource('tariffs','Admin\TariffController');
        Route::resource('transactions','Admin\TransactionController');
        Route::resource('videos','Admin\VideoController');
        Route::resource('banners','Admin\BannerController');
        Route::resource('supportTickets','Admin\SupportTicketController');

        Route::get('/', 'Admin\AdminPanelController@index')->name('adminPanel');
        Route::get('books', 'Admin\BookController@index')->name('booksPage');
        Route::get('books/{id}/edit/pages', 'Admin\BookController@book_pages')->name('booksPages');
        Route::post('books/{id}/edit/pages', 'Admin\BookController@edit_book_pages')->name('editBooksPages');
        Route::post('books/remove_page', 'Admin\BookController@remove_book_page')->name('removeBookPage');
        Route::post('sort_audio/{id}', 'Admin\BookController@sort_audio');
        Route::post('remove_audio/{id}', 'Admin\BookController@remove_audio');
        Route::post('upload/file', 'Admin\FileController@upload');
        Route::get('articles', 'Admin\ArticleController@index')->name('articlesPage');
        Route::get('authors', 'Admin\AuthorController@index')->name('authorsPage');
        Route::get('genres', 'Admin\GenreController@index')->name('genresPage');
        Route::get('categories', 'Admin\CategoryController@index')->name('categoriesPage');
        Route::get('invite_to_vip', 'Admin\InviteToVipController@index')->name('InviteToVipPage');
        Route::get('users', 'Admin\UserController@index')->name('usersPage');
        Route::get('role','Admin\RoleController@index')->name('rolePage');
        Route::get('info', 'Admin\InfoController@index')->name('infoPage');
        Route::get('page', 'Admin\PageController@index')->name('pagesPage');
        Route::get('tariffs', 'Admin\TariffController@index')->name('tariffsPage');
        Route::get('transactions', 'Admin\TransactionController@index')->name('transactionsPage');
        Route::get('supportTickets', 'Admin\SupportTicketController@index')->name('supportTicketsPage');
        Route::get('video', 'Admin\VideoController@index')->name('videosPage');
        Route::post('search_vip', 'Admin\VideoController@search_vip');
        Route::post('generate_vip_code', 'Admin\VideoController@generate_vip_code');
        Route::get('banners', 'Admin\BannerController@index')->name('bannersPage');
        Route::get('publishers', 'Admin\PublisherController@index')->name('publishersPage');
        Route::get('audio_load/{id}', 'Admin\BookController@loadAudioFiles')->name('loadAudioFiles');
    });
Route::get('/signin', 'Site\CreateAccountController@signin')->name('signin');
Route::get('/signup', 'Site\CreateAccountController@signup')->name('signup');
Route::get('/books', 'Site\BookController@index')->name('books');
Route::get('/audio_books', 'Site\BookController@audioBooks')->name('audio_books');
Route::get('/articles', 'Site\ArticleController@index')->name('articles');
Route::get('/videos/{category?}', 'Site\VideoController@index')->name('videos');
Route::get('/video/{id}', 'Site\VideoController@single')->name('video');
Route::get('/book/{id}', 'Site\BookController@singleBook')->name('book');
Route::get('/read/audio/{id}', 'Site\BookController@readBook')->name('listenBook');
Route::get('/read/book/{id}', 'Site\BookController@readBook')->name('readBook');
Route::get('/article/{id}', 'Site\ArticleController@singleBook')->name('article');
Route::get('/search', 'Site\SearchController@index')->name('search');
Route::get('/tariffs', 'Site\TariffController@index')->name('tariff');
Route::get('/comments/store', 'Site\CommentController@store')->name('comment');
Route::get('/profile', 'Site\ProfileController@index')->name('profile')->middleware('auth');
Route::get('/favorite', 'Site\FavoriteController@index')->name('favorite')->middleware('auth');

Route::get('add-to-favorite/{type}/{id}', 'Site\FavoriteController@addToFavorite')->name('addToFavorite');
Route::get('remove-in-favorite/{type}/{id}', 'Site\FavoriteController@removeInFavorite')->name('removeInFavorite');
Route::post('favorite/{book}', 'Site\BookController@favoriteBook')->name('favoriteBook');
Route::post('unfavorite/{book}', 'Site\BookController@unFavoriteBook')->name('unfavoriteBook');
Route::get('/profile/edit/{id}', 'Site\ProfileController@edit')->name('profileEdit');
Route::post('/profile/update/{user}', 'Site\ProfileController@update')->name('updateProfile');
Route::get('/page/{id}', 'Site\PageController@getPage')->name('page');




Route::post('/buy/{type}/{object_id}', 'Site\PaymentController@buy')->middleware('auth')->name('buy');
Route::get('payment/success', 'Site\PaymentController@success');

Route::get('read_book/{id}', 'Site\BookController@read_book')->name('read_book');
Route::get('mobile_read_book/{id}', 'Site\BookController@mobile_read_book')->name('mobile_read_book');
Route::get('mobile_read_book_page/{page}', 'Site\BookController@mobile_read_book_page')->name('mobile_read_book_page');
Route::get('mobile_read_book/images/ajax-loader.gif', function (){
    return 'OK-200';
});
