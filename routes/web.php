<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UsersController;
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
    return view('admin/index');
});
Route::get('/users', function () {
    return view('admin/users/users');
});
Route::get('admin/users',[UsersController::class,'index']);
