<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticleController;
//

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
    //Route::get('products', [ProductController::class, 'index']);
    //Route::get('products/{id}', [ProductController::class, 'show']);
    //Route::post('create', [ProductController::class, 'store']);
    //Route::put('update/{product}',  [ProductController::class, 'update']);
    //Route::delete('delete/{product}',  [ProductController::class, 'destroy']);
});

Route::get('article', [ArticleController::class, 'index']);
Route::get('article/{id}', [ArticleController::class, 'show']);
Route::post('create', [ArticleController::class, 'store']);
Route::put('update/{id}',  [ArticleController::class, 'update']);
Route::delete('delete/{id}',  [ArticleController::class, 'destroy']);


