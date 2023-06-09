<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});



Route::get('/exp', function () {
    $fake = fake()->image();
    $saveFile = Storage::putFile('/public/products', $fake, 'public');
    return explode("/", $saveFile)[2];
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/exp', function () {
    return view('layouts.main');
});
Route::get('/transaction', function () {
    return view('pages.transaction');
});
