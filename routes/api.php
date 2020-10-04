<?php

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
    return $request->user();
});
Route::middleware('auth:sanctum')->post('get_book/{id}', 'Api\BookController@get_html');
Route::middleware('auth:sanctum')->get('home_screen', 'Api\HomeScreenController@index');
Route::middleware('auth:sanctum')->get('articles', 'Api\ArticleController@index');
Route::middleware('auth:sanctum')->get('articles/{id}', 'Api\ArticleController@view');
Route::middleware('auth:sanctum')->post('comment/{object_type}/{id}', 'Api\CommentController@create');
Route::middleware('auth:sanctum')->post('vote/{object_type}/{id}', 'Api\VoteController@create');
//Route::get('book', 'Api\BookController');
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