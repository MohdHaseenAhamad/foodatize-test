<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\HeaderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\DashboardController;
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


Route::get('/header',[HeaderController::class,'index']);

Route::get('/admin',[DashboardController::class,'index']);
Route::get('admin/users',[UsersController::class,'index']);
Route::get('admin/users/delete/{id}',[UsersController::class,'deleteUser']);
Route::get('admin/orders',[OrderController::class,'index']);
Route::post('admin/orders/change-status/{id}',[OrderController::class,'changeStatus']);
Route::get('admin/orders/detail/{id}',[OrderController::class,'detail']);
Route::get('admin/products',[ProductController::class,'index']);
Route::get('admin/products/add',[ProductController::class,'add']);
Route::post('admin/products/save',[ProductController::class,'save']);
Route::get('admin/products/edit/{id}',[ProductController::class,'edit']);
Route::post('admin/products/update/{id}',[ProductController::class,'update']);
Route::get('admin/products/delete/{id}',[ProductController::class,'delete']);
