<?php

use App\Http\Controllers\API\ProductServiceController;
use App\Http\Controllers\API\CategoryServiceController;
use App\Http\Controllers\API\OrderServiceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
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
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
});

Route::resource('/products', ProductServiceController::class)->middleware('admin')->only('index', 'show', 'store')->middleware('user');
Route::resource('/categories', CategoryServiceController::class)->middleware('admin');
Route::resource('/orders', OrderServiceController::class)->middleware('admin');

Route::get('/get-login', function () {
    return response()->json(['error' => 'Unauthorized'], 401);
})->name('get-login');
