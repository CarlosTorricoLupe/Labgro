<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;

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

/* Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
}); */

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('logout', [AuthController::class, 'logout']);
    Route::get('get_user', [AuthController::class, 'get_user']);

    Route::get('users', [UserController::class, 'index']);
    Route::post('users/create', [UserController::class, 'store']);
    Route::put('users/update/{user}', [UserController::class, 'update']);
    Route::delete('users/delete/{user}',  [UserController::class, 'destroy']);

});

Route::apiResource('categories',CategoryController::class);

Route::apiResource('articles',ArticleController::class);



Route::get('/permission', function () {
   /* $user = App\Models\User::where('name','canaviri')->first();
    $op = $user->role->permissions()->where('name', 'views_articles')->exists();
    dd($op);
    return $op;*/

    $categorie1 = App\Models\Category::where('name','Material de escritorio')->first();
    dd($categorie1->id);

});


//https://www.youtube.com/watch?v=2f0ucOIQJko&list=PLwNeytHvRMPxnPxvEckKJ73c2FxvSoZyY&index=9
