<?php

use Illuminate\Support\Facades\Route;

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

// User login routes
Route::get('/login', [App\Http\Controllers\Auth\AuthController::class, 'index'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\AuthController::class, 'store'])->name('login.store');

// User registration routes
Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'index'])->name('register');
Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'store'])->name('register.store');

// Forget Password routes
Route::get('reset-password/{token}', [App\Http\Controllers\Auth\ForgetPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('/forget-password', [App\Http\Controllers\Auth\ForgetPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
Route::post('reset-password', [App\Http\Controllers\Auth\ForgetPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');


Route::group(['middleware' => 'auth'], function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    });
    
    Route::get('/logout', [App\Http\Controllers\Auth\AuthController::class, 'logout'])->name('logout');

});
