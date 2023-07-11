<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Website\UsersController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Api\Website\AddressContoller;
use App\Http\Controllers\Api\Website\CardController;
use App\Http\Controllers\Api\Website\OrderController;
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
//Route::group(['middleware'=>'Api/Website'],function($routes){
//    Route::post('user/register',[UserController::class,'register']);
//    Route::post('user/login',[UserController::class,'login']);
//    Route::post('user/profile',[UserController::class,'profile']);
//});

Route::post('user/store',[UsersController::class,'store']);
Route::post('user/otp-verification',[UsersController::class,'otpVerification']);
Route::put('user/save-basic-info/{id}',[UsersController::class,'saveBasicInfo']);

Route::post('product',[ProductController::class,'index']);
Route::post('product/store',[ProductController::class,'store']);
Route::post('product/search', [ProductController::class,'filter']);

Route::post('address/store',[AddressContoller::class,'store']);
Route::get('address/edit/{id}',[AddressContoller::class,'edit']);
Route::put('address/update/{id}',[AddressContoller::class,'update']);
Route::get('address/show/{id}',[AddressContoller::class,'show']);

Route::get('add-to-cart/{id}', [CardController::class, 'addToCart']);
Route::patch('update-cart', [CardController::class, 'update']);
Route::delete('remove-from-cart', [CardController::class, 'remove']);


Route::post('order/store',[OrderController::class,'store']);
//Route::get('student',[::class,'index']);
//Route::get('student/show/{id}',[UserController::class,'show']);
//Route::put('student/update/{id}',[UserController::class,'update']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
