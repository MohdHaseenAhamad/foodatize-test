<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Website\UsersController;

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
Route::post('user/save-basic-info',[UsersController::class,'saveBasicInfo']);
//Route::get('student',[UserController::class,'index']);
//Route::get('student/show/{id}',[UserController::class,'show']);
//Route::put('student/update/{id}',[UserController::class,'update']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
