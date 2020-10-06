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
        "profile_photo_path"=> url($user->profile_photo_path),
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
Route::middleware('auth:sanctum')->get('/user/my_audio_books', 'Api\UserController@my_audio_books');
Route::middleware('auth:sanctum')->get('/user/my_tariff', 'Api\UserController@my_tariff');
Route::middleware('auth:sanctum')->get('/user/book_shelfs', 'Api\UserController@book_shelfs');
Route::middleware('auth:sanctum')->get('/user/book_shelfs/{id}', 'Api\UserController@book_shelfs_view');
Route::middleware('auth:sanctum')->post('/user/book_shelfs/{id}', 'Api\UserController@book_shelfs_update');
Route::middleware('auth:sanctum')->post('/user/add_to_book_shelf/{id}', 'Api\UserController@add_to_book_shelf');
Route::middleware('auth:sanctum')->post('/user/remove_in_book_shelf/{id}', 'Api\UserController@remove_in_book_shelf');
Route::middleware('auth:sanctum')->post('get_book/{id}', 'Api\BookController@get_html');

/**
 * Home Screen
 */
Route::middleware('auth:sanctum')->get('home_screen', 'Api\HomeScreenController@index');

/**
 * Help
 */
Route::middleware('auth:sanctum')->get('/help', 'Api\HelpController@index');
Route::middleware('auth:sanctum')->post('/help', 'Api\HelpController@create');

/**
 * Articles
 */
Route::middleware('auth:sanctum')->get('articles', 'Api\ArticleController@index');
Route::middleware('auth:sanctum')->get('articles/{id}', 'Api\ArticleController@view');

/**
 * Books
 */
Route::middleware('auth:sanctum')->get('books', 'Api\BookController@index');
Route::middleware('auth:sanctum')->get('books/group_by_genre', 'Api\BookController@group_by_genre');
Route::middleware('auth:sanctum')->get('books/{id}', 'Api\BookController@view');
Route::middleware('auth:sanctum')->post('get_book/{id}', 'Api\BookController@get_html');

/**
 * Audio-Books
 */
Route::middleware('auth:sanctum')->get('audio_books', 'Api\AudioBooksController@index');
Route::middleware('auth:sanctum')->get('audio_books/{id}', 'Api\AudioBooksController@view');

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