<?php

use App\Helpers\DateHelper;
use App\Helpers\PhoneHelper;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
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
Route::fallback(function () {
    return response()->json(['message' => 'Entity Not Found'], 404);
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    $user = $request->user();
    $data = [
        "id" => $user->id,
        "name" => $user->name,
        "email" => $user->email,
        "date_of_birth" => DateHelper::changeDateFormat($user->date_of_birth, 'd.m.Y', 'Y-m-d'),
        "phone" => PhoneHelper::formatFromNumeric($user->phone),
        "profile_photo_path" => url('uploads/' . $user->profile_photo_path),
        "tariff_id" => $user->tariff_id,
        "have_active_tariff" => $user->have_active_tariff(),
        "tariff_price_list_id" => $user->tariff_price_list_id,
        "created_at" => $user->created_at,
        "updated_at" => $user->updated_at,
        "tariff_begin_date" => $user->tariff_begin_date,
        "tariff_end_date" => $user->tariff_end_date
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
Route::middleware('auth:sanctum')->post('v2/get_book/{id}', 'Api\BookController@get_html_by_paginate');
Route::middleware('auth:sanctum')->post('check_vip_code', 'Api\VideoController@check_vip_code');
Route::middleware(\App\Http\Middleware\CourseAuth::class)->get('/courses/{course_key?}', 'Site\CourseController@index');
Route::middleware(\App\Http\Middleware\CourseAuth::class)->get('/courses/lesson/{id}', 'Site\CourseController@lesson');
Route::middleware(\App\Http\Middleware\CourseAuth::class)->post('/courses/finish_lesson/{id}', 'Site\CourseController@finish_lesson');
Route::get('/user/v2', 'Api\UserController@info');
Route::get('/user/terms_of_use', 'Api\UserController@terms_of_use');
Route::get('/user/privacy_policy', 'Api\UserController@privacy_policy');
Route::get('/quotes/{book_id?}', 'Api\BookController@quotes');
Route::post('/quotes', 'Api\BookController@add_quote')->name('add_quote');
Route::post('/remove_quotes/{id}', 'Api\BookController@remove_quote');
Route::post('/bookmarks', 'Api\BookController@add_book_marks')->name('add_book_marks');
Route::get('/bookmarks/{book_id?}', 'Api\BookController@book_marks');
Route::post('/remove_bookmark/{id}', 'Api\BookController@remove_bookmark');
Route::post('/save_book_state', 'Api\BookController@save_book_state')->name('save_book_state');
Route::post('/in_app_purchase', 'Api\OrderController@in_app_purchase')->name('in_app_purchase');
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
Route::get('categories', 'Api\ArticleController@categories');


/**
 * Comments
 */
Route::get('comment/{object_type}/{id}', 'Api\CommentController@index');
Route::middleware('auth:sanctum')->post('comment/{object_type}/{id}', 'Api\CommentController@create');

/**
 * Rating
 */
Route::middleware('auth:sanctum')->post('vote/{object_type}/{id}', 'Api\VoteController@create');

/**
 * Tariffs
 */
Route::get('tariffs', 'Api\OrderController@tariffs');
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

    if (!$user || !Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['Не правильный email или пароль!'],
        ]);
    }

    \App\Device::saveDevice($user);
    return response(['token' => $user->createToken(time())->plainTextToken]);
});
Route::post('password_reset', 'Auth\ForgotPasswordController@sendResetLinkEmail');
Route::post('register', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'name' => 'required',
    ]);

    $user = User::query()->where('email', $request->email)->first();

    if ($user) {
        throw ValidationException::withMessages([
            'email' => ['Пользователь уже зарегистрирован!'],
        ]);
    }
    try {
        $user = new User();
        $user->setAttribute('email', $request->email);
        $user->setAttribute('password', Hash::make($request->password));
        $user->setAttribute('name', $request->name);
        if ($request->header('DeviceUID')) {
            if ($device = \App\ApplePurchaseDevice::query()->where('device_id', $request->header('DeviceUID'))->first()) {
                if ($device->have_active_tariff()) {
                    $user->setAttribute('tariff_id', $device->tariff_id);
                    $user->setAttribute('tariff_price_list_id', $device->tariff_price_list_id);
                    $user->setAttribute('tariff_begin_date', $device->tariff_begin_date);
                    $user->setAttribute('tariff_end_date', $device->tariff_end_date);
                }
            }
        }
        $user->save();
        \App\Device::saveDevice($user);
    } catch (Exception $e) {
        throw ValidationException::withMessages([
            'Не известная ошибка сервера!',
        ]);
    }


    return response(['token' => $user->createToken(time())->plainTextToken]);
});

Route::post('register/google', function (Request $request) {
    $request->validate([
        'id_token' => 'required'
    ]);
    $response = Http::get('https://oauth2.googleapis.com/tokeninfo?id_token=' . $request->id_token);
    if ($response && $response->status() == 200) {
        $data = $response->json();
        if ($data['email']) {
            $user = User::query()->where('email', $data['email'])->first();
            if (!$user) {
                try {
                    $user = new User();
                    $user->setAttribute('email', $data['email']);
                    $user->setAttribute('password', Hash::make($data['email']));
                    $user->setAttribute('name', $data['name']);
                    $user->save();
                    \App\Device::saveDevice($user);
                } catch (Exception $e) {
                    throw ValidationException::withMessages([
                        'Не известная ошибка! Попробуйте позже.',
                    ]);
                }
            }
            return response(['token' => $user->createToken(time())->plainTextToken]);
        }
    }
    throw ValidationException::withMessages([
        'Не известная ошибка!',
    ]);
});

Route::post('payment/result', 'Site\PaymentController@result');