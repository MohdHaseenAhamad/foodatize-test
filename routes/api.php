<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Website\UsersController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Api\Website\AddressContoller;
use App\Http\Controllers\Api\Website\CartController;
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

/* Testing Done Start */
Route::post('user/register-users',[UsersController::class,'registerUsers']);
Route::post('user/otp-verification',[UsersController::class,'otpVerification']);
Route::put('user/save-basic-info/{id}',[UsersController::class,'saveBasicInfo']);
Route::put('user/update/{id}',[UsersController::class,'update']);
/* Testing End */


Route::get('product',[ProductController::class,'index']);
Route::post('product/store',[ProductController::class,'store']);
Route::post('product/search', [ProductController::class,'filter']);

Route::post('address/store',[AddressContoller::class,'store']);
Route::get('address/edit/{id}',[AddressContoller::class,'edit']);
Route::put('address/update/{id}',[AddressContoller::class,'update']);
Route::get('address/show/{id}',[AddressContoller::class,'show']);
Route::delete('address/delete/{id}',[AddressContoller::class,'destroy']);

Route::get('get-user-cart-info/{id}', [CartController::class, 'getAllCartUserData']);
Route::post('add-to-cart/{id}', [CartController::class, 'addToCart']);
//Route::get('add-to-cart/{id}', [CardController::class, 'addToCart']);
//Route::patch('update-cart', [CartController::class, 'update']);
Route::delete('remove-from-cart/{id}', [CartController::class, 'remove']);


Route::post('checkout',[OrderController::class,'store']);
Route::get('product-checker-for-price/{id}',[OrderController::class,'productCheckerForPrice']);
Route::get('product-checker-for-qty/{id}',[OrderController::class,'productCheckerForQty']);

//Route::post('select-payment-method',[OrderController::class,'selectPaymentMethod']);
Route::post('get-price',[AddressContoller::class,'getPrice']);

//Route::get('student',[::class,'index']);
//Route::get('student/show/{id}',[UserController::class,'show']);
//Route::put('student/update/{id}',[UserController::class,'update']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
