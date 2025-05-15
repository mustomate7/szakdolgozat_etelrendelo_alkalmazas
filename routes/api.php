<?php

use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\MenuController;
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

Route::get('/menu', [MenuController::class, 'getWeeklyMenu'])->name('menu.fetch');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/cart/list', [CartController::class, 'list'])->name('cart.list');
    Route::post('/cart/add', [CartController::class, 'store'])->name('cart.add');
    Route::get('/user', fn(Request $request) => $request->user());
});
