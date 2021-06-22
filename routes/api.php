<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticleController;
//use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;

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

Route::get('categories', [CategoryController::class,'index'])->name('categories');
Route::post('categories/create', [CategoryController::class,'store'])->name('categories');
Route::get('categories/{category}', [CategoryController::class,'show'])->name('categories');
Route::put('categories/{category}', [CategoryController::class,'update'])->name('categories');
Route::delete('categories/{category}',  [CategoryController::class, 'destroy']);

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('logout', [AuthController::class, 'logout']);
    Route::get('get_user', [AuthController::class, 'get_user']);
    //Route::get('products', [ProductController::class, 'index']);
    //Route::get('products/{id}', [ProductController::class, 'show']);
    //Route::post('create', [ProductController::class, 'store']);
    //Route::put('update/{product}',  [ProductController::class, 'update']);
    //Route::delete('delete/{product}',  [ProductController::class, 'destroy']);
});

/*Route::get('articles', [ArticleController::class, 'index'])->name('articles');
Route::get('article/{articles}', [ArticleController::class, 'show'])->name('articles');
Route::post('articles/create', [ArticleController::class, 'store'])->name('articles');
Route::put('articles/{articles}',  [ArticleController::class, 'update'])->name('articles');
Route::delete('articles/{articles}',  [ArticleController::class, 'destroy'])->name('articles');*/

Route::apiResource('articles',ArticleController::class);



Route::get('/permission', function () {
    $user = App\Models\User::where('name','canaviri')->first();
    $op = $user->role->permissions()->where('name', 'views_articles')->exists();
    dd($op);
    return $op;
});

Route::get('users', [UserController::class, 'index']);
Route::post('users/create', [UserController::class, 'store']);
Route::put('users/update/{user}', [UserController::class, 'update']);
Route::delete('users/delete/{user}',  [UserController::class, 'destroy']);


//https://www.youtube.com/watch?v=2f0ucOIQJko&list=PLwNeytHvRMPxnPxvEckKJ73c2FxvSoZyY&index=9
