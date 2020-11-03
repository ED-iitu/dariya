<?php

use App\Helpers\DateHelper;
use App\Helpers\PhoneHelper;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::fallback(function(){
    return response()->json(['message' => 'Entity Not Found'], 404);
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    $user = $request->user();
    $data = [
        "id"=> $user->id,
        "name"=> $user->name,
        "email"=> $user->email,
        "date_of_birth"=> DateHelper::changeDateFormat($user->date_of_birth,'d.m.Y', 'Y-m-d'),
        "phone"=> PhoneHelper::formatFromNumeric($user->phone),
        "profile_photo_path"=> url('uploads/'.$user->profile_photo_path),
        "tariff_id"=> $user->tariff_id,
        "tariff_price_list_id"=> $user->tariff_price_list_id,
        "created_at"=> $user->created_at,
        "updated_at"=> $user->updated_at,
        "tariff_begin_date"=> $user->tariff_begin_date,
        "tariff_end_date"=> $user->tariff_end_date
    ];
    return $data;
});
Route::middleware('auth:sanctum')->post('/user', 'Api\UserController@update');
Route::middleware('auth:sanctum')->get('/user/my_books', 'Api\UserController@my_books');
Route::middleware('auth:sanctum')->post('/user/my_books/{id}', 'Api\UserController@add_to_my_books');
Route::middleware('auth:sanctum')->post('/user/my_books/remove/{id}', 'Api\UserController@remove_in_my_books');
Route::middleware('auth:sanctum')->get('/user/my_audio_books', 'Api\UserController@my_audio_books');
Route::middleware('auth:sanctum')->get('/user/my_tariff', 'Api\UserController@my_tariff');
Route::middleware('auth:sanctum')->get('/user/book_shelfs', 'Api\UserController@book_shelfs');
Route::middleware('auth:sanctum')->get('/user/book_shelfs/{id}', 'Api\UserController@book_shelfs_view');
Route::middleware('auth:sanctum')->get('/user/favorites', 'Api\UserController@favorites');
Route::middleware('auth:sanctum')->get('/user/push_settings', 'Api\UserController@push_settings');
Route::middleware('auth:sanctum')->post('/user/push_settings/{id}', 'Api\UserController@toggle_settings');
Route::middleware('auth:sanctum')->post('/user/book_shelfs', 'Api\UserController@book_shelfs_add');
Route::middleware('auth:sanctum')->post('/user/book_shelfs/{id}', 'Api\UserController@book_shelfs_update');
Route::middleware('auth:sanctum')->post('/user/remove_book_shelfs/{id}', 'Api\UserController@book_shelfs_remove');
Route::middleware('auth:sanctum')->post('/user/add_to_book_shelf/{id}', 'Api\UserController@add_to_book_shelf');
Route::middleware('auth:sanctum')->post('/user/remove_in_book_shelf/{id}', 'Api\UserController@remove_in_book_shelf');
Route::middleware('auth:sanctum')->post('/user/toggle_favorites/{type}/{id}', 'Api\UserController@toggle_favorites');
Route::middleware('auth:sanctum')->post('get_book/{id}', 'Api\BookController@get_html');

/**
 * Search
 */
Route::get('search', 'Api\SearchController@index');

/**
 * Home Screen
 */
Route::get('home_screen', 'Api\HomeScreenController@index');

/**
 * Help
 */
Route::get('help', 'Api\HelpController@index');
Route::middleware('auth:sanctum')->post('help', 'Api\HelpController@create');

/**
 * Articles
 */
Route::get('articles', 'Api\ArticleController@index');
Route::get('articles/{id}', 'Api\ArticleController@view');

/**
 * Books
 */
Route::get('books', 'Api\BookController@index');
Route::get('books/group_by_genre', 'Api\BookController@group_by_genre');
Route::get('books/{id}', 'Api\BookController@view');
Route::get('related_books/{id}', 'Api\BookController@relatedBooks');
Route::middleware('auth:sanctum')->post('get_book/{id}', 'Api\BookController@get_html');

/**
 * Audio-Books
 */
Route::get('audio_books', 'Api\AudioBooksController@index');
Route::get('audio_books/{id}', 'Api\AudioBooksController@view');

/**
 * Videos
 */
Route::get('videos', 'Api\VideoController@index');
Route::get('videos/{id}', 'Api\VideoController@view');

/**
 * Tops
 */
Route::get('top_books/{type?}', 'Api\TopsController@books');
Route::get('top_audio_books/{type?}', 'Api\TopsController@audio_books');
Route::get('news/{type?}', 'Api\TopsController@news');

Route::get('genres', 'Api\BookController@genres');


/**
 * Comments
 */
Route::middleware('auth:sanctum')->post('comment/{object_type}/{id}', 'Api\CommentController@create');

/**
 * Rating
 */
Route::middleware('auth:sanctum')->post('vote/{object_type}/{id}', 'Api\VoteController@create');

/**
 * Tariffs
 */
Route::middleware('auth:sanctum')->get('tariffs', 'Api\OrderController@tariffs');
Route::middleware('auth:sanctum')->post('create_order/{type}/{object_id}', 'Api\OrderController@create');

/**
 * Auth
 */
Route::post('auth', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    $user = User::query()->where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    return response(['token'=>$user->createToken(time())->plainTextToken]);
});
Route::post('register', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'name' => 'required',
    ]);

    $user = User::query()->where('email', $request->email)->first();

    if ($user) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }
    try{
        $user = new User();
        $user->setAttribute('email', $request->email);
        $user->setAttribute('password', Hash::make($request->email));
        $user->setAttribute('name', $request->name);
        $user->save();
    }catch (Exception $e){
        throw ValidationException::withMessages([
            'Internal Error Server',
        ]);
    }


    return response(['token'=>$user->createToken(time())->plainTextToken]);
});