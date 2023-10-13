<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('layouts.master');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



Route::get('/product', [App\Http\Controllers\ProductController::class, 'index']);
Route::get('/product/search', [App\Http\Controllers\ProductController::class, 'search']);
Route::post('/product/search', [App\Http\Controllers\ProductController::class, 'search']);
Route::get('/product/edit/{id?}' , [App\Http\Controllers\ProductController::class, 'edit']);
Route::post('/product/update' , [App\Http\Controllers\ProductController::class, 'update']);
Route::post('/product/edit' , [App\Http\Controllers\ProductController::class, 'insert']);
Route::get('/product/remove/{id?}' , [App\Http\Controllers\ProductController::class, 'remove']);


Route::get('/category', [App\Http\Controllers\CategoryController::class, 'index']);
Route::post('/category/search', [App\Http\Controllers\CategoryController::class, 'search']);
Route::get('/category/edit/{id?}' , [App\Http\Controllers\CategoryController::class, 'edit']);
Route::post('/category/update' , [App\Http\Controllers\CategoryController::class, 'update']);
Route::post('/category/edit' , [App\Http\Controllers\CategoryController::class, 'insert']);
Route::get('/category/remove/{id?}' , [App\Http\Controllers\CategoryController::class, 'remove']);

Route::get('/cart/view', [App\Http\Controllers\CartController::class, 'viewCart']);
Route::get('/cart/add/{id}', [App\Http\Controllers\CartController::class, 'addToCart']);
Route::get('/cart/delete/{id}', [App\Http\Controllers\CartController::class, 'deleteCart']);
Route::get('/cart/update/{id}/{qty}', [App\Http\Controllers\CartController::class, 'updateCart']);

Route::get('/cart/checkout', [App\Http\Controllers\CartController::class, 'checkout']);
Route::get('/cart/complete', [App\Http\Controllers\CartController::class, 'complete']);
Route::get('/cart/finish' , [App\Http\Controllers\CartController::class, 'finish_order']);

Auth::routes();


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/logout',[App\Http\Controllers\Auth\LoginController::class, 'logout']);
