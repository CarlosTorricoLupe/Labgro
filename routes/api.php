<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\OutputController;
use App\Http\Controllers\RawMaterialController;

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

Route::group(['middleware' => ['api']], function() {
    Route::get('logout', [AuthController::class, 'logout']);
    Route::get('get_user', [AuthController::class, 'get_user']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('users', [UserController::class, 'index']);
    Route::post('users/create', [UserController::class, 'store']);
    Route::put('users/update/{user}', [UserController::class, 'update']);
    Route::delete('users/delete/{user}',  [UserController::class, 'destroy']);

});

Route::apiResource('categories',CategoryController::class);
Route::get('search/category/{name}', [CategoryController::class,'search']);

Route::apiResource('articles',ArticleController::class);
Route::get('search', [ArticleController::class, 'searchArticle']);
Route::get('search_category', [ArticleController::class, 'searchArticleForCategorgy']);

Route::apiResource('units',UnitController::class);

Route::apiResource('sections',SectionController::class);


/* Route::apiResource('incomes',IncomeController::class); */




Route::get('/permission', function () {
   /* $user = App\Models\User::where('name','canaviri')->first();
    $op = $user->role->permissions()->where('name', 'views_articles')->exists();
    dd($op);
    return $op;*/

    //$categorie1 = App\Models\Category::where('name','Material de escritorio')->first();
    //dd($categorie1->id);

    $categories = Category::all('name');
    return $categories;
});

Route::get("output/", [OutputController::class, 'index']);
Route::get("output/getDetailOutput/", [OutputController::class, 'getDetailOutput']);
Route::post("output/create", [OutputController::class, 'store']);
Route::post("output/search", [OutputController::class, 'searchOutputByDate']);

Route::get("output/articles/{section}", [OutputController::class, 'getArticles']);
Route::put("output/update/{output}", [OutputController::class, 'update']);
Route::delete("output/delete/{output}", [OutputController::class, 'destroy']);
Route::get('/output/{output}',[OutputController::class, 'show']);
Route::get('/output/by_article/{id}',[OutputController::class, 'outputsByArticle']);

Route::get("prueba", [OutputController::class, 'prueba']);

Route::get('/incomes',[IncomeController::class, 'index']);
Route::post('/incomes',[IncomeController::class, 'store']);
Route::get('/incomes/getDetailsIncome/', [IncomeController::class, 'getDetailsIncome']);
Route::get('/incomes/{income}',[IncomeController::class, 'show']);
Route::put('/incomes/{income}', [IncomeController::class, 'update']);
Route::delete('/incomes/{income}', [IncomeController::class, 'destroy']);
Route::get('/incomes/getIncomesArticle/{id}', [IncomeController::class, 'getIncomesArticle']);


//VERIFIRY PRICE
Route::get('/verifyPriceArticle/{id}', [OutputController::class, 'verififyPriceArticle']);
Route::post('materialsOrder/create',[MaterialsOrderController::class,'store']);


//https://www.youtube.com/watch?v=2f0ucOIQJko&list=PLwNeytHvRMPxnPxvEckKJ73c2FxvSoZyY&index=9



