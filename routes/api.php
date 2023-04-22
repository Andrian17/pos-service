<?php

use App\Http\Controllers\API\ProductServiceController;
use App\Http\Controllers\API\CategoryServiceController;
use App\Http\Controllers\API\OrderServiceController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\OrderProductServiceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/refresh', [AuthController::class, 'refresh']);
        Route::get('/user-profile', [AuthController::class, 'userProfile']);
    });
});



Route::group(['middleware' => ['auth:api', 'admin'], 'prefix' => 'admin'], function () {
    Route::apiResource('/products', ProductServiceController::class);
    Route::resource('/categories', CategoryServiceController::class);
    Route::resource('/orders', OrderServiceController::class);
    Route::resource('/order-product', OrderProductServiceController::class)->only(['index', 'show']);
});
Route::group(['middleware' => ['auth:api', 'user']], function () {
    Route::resource('/products', ProductServiceController::class)->only("show", "index", "store");
    Route::resource('/categories', CategoryServiceController::class)->only("show", "index");
    Route::resource('/orders', OrderServiceController::class)->only("store", "index", 'show');
    Route::apiResource('/order-product', OrderProductServiceController::class)->only(['index', 'show']);
});

Route::get('/get-login', function () {
    return response()->json(['error' => 'Unauthorized'], 401);
})->name('get-login');
