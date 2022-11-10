<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\OutputController;
use App\Http\Controllers\PresentationUnitController;
use App\Http\Controllers\RawMaterialController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PresentationProductionProductController;
use App\Http\Controllers\ProductionController;
use App\Http\Controllers\ProductionProductController;
use App\Http\Controllers\ProductMaterialController;
use App\Http\Controllers\ProductPresentationController;
use Illuminate\Routing\Route as RoutingRoute;

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

Route::group(['middleware' => ['auth:api']], function() {
    Route::get('logout', [AuthController::class, 'logout']);
    Route::get('get_user', [AuthController::class, 'get_user']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('users', [UserController::class, 'index']);
    Route::post('users/create', [UserController::class, 'store']);
    Route::put('users/update/{user}', [UserController::class, 'update']);
    Route::delete('users/delete/{user}',  [UserController::class, 'destroy']);
    Route::apiResource('articles', ArticleController::class);
    Route::apiResource('categories',CategoryController::class);
    Route::get('search/category/{name}', [CategoryController::class,'search']);


    Route::get('search', [ArticleController::class, 'searchArticle']);
    Route::get('search_category', [ArticleController::class, 'searchArticleForCategorgy']);

    Route::apiResource('units',UnitController::class);

    Route::apiResource('sections',SectionController::class);

    Route::apiResource('raw_material',RawMaterialController::class);

    Route::apiResource('products',ProductController::class);

    Route::apiResource('materials',MaterialController::class);
    Route::get('material/incomes_graphics', [MaterialController::class, 'IncomesMaterialByGraphics']);
    Route::get('material/{id}/quantityLeftover', [MaterialController::class, 'getQuantityLeftOver']);

    Route::apiResource('orders', OrderController::class);
    Route::get('order_reprobate/{id}', [OrderController::class, 'reprobate']);
    Route::get('notifications', [OrderController::class, 'notifications']);
    Route::get('quantity_notifications', [OrderController::class, 'quantity_notifications']);
    Route::get('view_notifications/{id}', [OrderController::class, 'view_notifications']);


    Route::apiResource('presentations', PresentationUnitController::class);

    Route::apiResource('product.materials',ProductMaterialController::class);


    Route::get('material/{id}/incomes', [ProductMaterialController::class, 'getIncomeMaterials']);
    Route::get('material/{id}/outputs', [ProductMaterialController::class, 'getOutputsMaterials']);

    /* Route::apiResource('incomes',IncomeController::class); */

    Route::apiResource('product.presentations',ProductPresentationController::class);

    Route::apiResource('productions', ProductionController::class);
    Route::get('getConsolidate',[ProductionController::class,'getConsolidate']);
    Route::get('getDetailProduction',[ProductionController::class,'getDetailProduction']);
    Route::put('updateQuantityForProduction',[ProductionController::class,'updateQuantityUsedInProduction']);
    Route::get('getSummaryProduction',[ProductionController::class,'getSummaryProduction']);
    Route::get('getMaterialsConsumed',[ProductionProductController::class,'getMaterialsConsumed']);

    Route::apiResource('production.products',ProductionProductController::class);
    Route::get('verifyMaterials', [ProductionProductController::class, 'verifyStockMaterial']);
    Route::get('details/productions',[ProductionProductController::class,'showProductionByDay']);
    Route::get('productions_details/{id}', [ProductionProductController::class, 'getProductionsById']);
    Route::apiResource('production.product.presentations',PresentationProductionProductController::class);
    Route::get('getMaterialsConsumed',[ProductionProductController::class,'getMaterialsConsumed']);

    Route::get("output/", [OutputController::class, 'index']);
    Route::get("output/getDetailOutput/", [OutputController::class, 'getDetailOutput']);
    Route::post("output/create/{id_order?}", [OutputController::class, 'store']);
    Route::post("output/search", [OutputController::class, 'searchOutputByDate']);

    Route::get("output/articles/{section}", [OutputController::class, 'getArticles']);
    Route::put("output/update/{output}", [OutputController::class, 'update']);
    Route::delete("output/delete/{output}", [OutputController::class, 'destroy']);
    Route::get('/output/{output}',[OutputController::class, 'show']);
    Route::get('/output/by_article/{id}',[OutputController::class, 'outputsByArticle']);
    Route::get('/outputs/getOutputArticleByDate', [OutputController::class, 'getOutputArticleByDate']);

    Route::get("prueba", [OutputController::class, 'prueba']);

    Route::get('/incomes',[IncomeController::class, 'index']);
    Route::post('/incomes',[IncomeController::class, 'store']);
    Route::get('/incomes/getDetailsIncome/', [IncomeController::class, 'getDetailsIncome']);
    Route::get('/incomes/byDetails/', [IncomeController::class, 'getDetailsIncome']);
    Route::get('/incomes/{income}',[IncomeController::class, 'show']);
    Route::put('/incomes/{income}', [IncomeController::class, 'update']);
    Route::delete('/incomes/{income}', [IncomeController::class, 'destroy']);
    Route::get('/incomes/getIncomesArticle/{id}', [IncomeController::class, 'getIncomesArticle']);
    Route::get('/peripheralReport', [ArticleController::class, 'peripheralReport']);
    Route::get('/income/getIncomeArticleByDate', [IncomeController::class, 'getIncomeArticleByDate']);


//VERIFIRY PRICE
    Route::get('/verifyPriceArticle/{id}', [OutputController::class, 'verififyPriceArticle']);
    Route::get('/article/getPhysicalReport', [ArticleController::class, 'physicalReport']);
    Route::get('article/getPhysicalReport/export', [ArticleController::class, 'PhysicalExport']);
    Route::get('getConsolidate/export', [ProductionController::class, 'consolidateExport']);
    Route::get('getDetailProduction/export',[ProductionController::class,'detailProductionExport']);
    Route::get('getSummaryProduction/export',[ProductionController::class,'summaryProductionExport']);
    Route::get('/peripheralReport/export', [ArticleController::class, 'peripheralReportExport']);
    Route::get('income/export', [IncomeController::class, 'incomeExport']);

});





//https://www.youtube.com/watch?v=2f0ucOIQJko&list=PLwNeytHvRMPxnPxvEckKJ73c2FxvSoZyY&index=9



