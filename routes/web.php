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

    // Routes for the Products
    Route::get('products', [App\Http\Controllers\Admin\ProductController::class, 'index'])->name('products.index');
    Route::get('products-list', [App\Http\Controllers\Admin\ProductController::class, 'product_list'])->name('products.list');
    Route::get('products/create', [App\Http\Controllers\Admin\ProductController::class, 'create'])->name('products.create');
    Route::post('products', [App\Http\Controllers\Admin\ProductController::class, 'store'])->name('products.store');
    Route::get('products/{id}', [App\Http\Controllers\Admin\ProductController::class, 'show'])->name('products.show');
    Route::get('products/{id}/edit', [App\Http\Controllers\Admin\ProductController::class, 'edit'])->name('products.edit');
    Route::post('products/{id}', [App\Http\Controllers\Admin\ProductController::class, 'update'])->name('products.update');
    Route::delete('products/{id}/delete', [App\Http\Controllers\Admin\ProductController::class, 'destroy'])->name('products.destroy');

    // Routes for the Customers
    Route::get('customers', [App\Http\Controllers\Admin\CustomerController::class, 'index'])->name('customers.index');
    Route::get('customers-list', [App\Http\Controllers\Admin\CustomerController::class, 'customer_list'])->name('customers.list');
    Route::get('customers/create', [App\Http\Controllers\Admin\CustomerController::class, 'create'])->name('customers.create');
    Route::post('customers', [App\Http\Controllers\Admin\CustomerController::class, 'store'])->name('customers.store');
    Route::get('customers/{id}', [App\Http\Controllers\Admin\CustomerController::class, 'show'])->name('customers.show');
    Route::get('customers/{id}/edit', [App\Http\Controllers\Admin\CustomerController::class, 'edit'])->name('customers.edit');
    Route::post('customers/{id}', [App\Http\Controllers\Admin\CustomerController::class, 'update'])->name('customers.update');
    Route::delete('customers/{id}/delete', [App\Http\Controllers\Admin\CustomerController::class, 'destroy'])->name('customers.destroy');

    // Routes for the Customers
    Route::get('sales', [App\Http\Controllers\Admin\CustomerController::class, 'index'])->name('sales.index');
    Route::get('sales-list', [App\Http\Controllers\Admin\CustomerController::class, 'sales_list'])->name('sales.list');
    Route::get('sales/create', [App\Http\Controllers\Admin\CustomerController::class, 'create'])->name('sales.create');
    Route::post('sales', [App\Http\Controllers\Admin\CustomerController::class, 'store'])->name('sales.store');
    Route::get('sales/{id}', [App\Http\Controllers\Admin\CustomerController::class, 'show'])->name('sales.show');
    Route::get('sales/{id}/edit', [App\Http\Controllers\Admin\CustomerController::class, 'edit'])->name('sales.edit');
    Route::post('sales/{id}', [App\Http\Controllers\Admin\CustomerController::class, 'update'])->name('sales.update');
    Route::delete('sales/{id}/delete', [App\Http\Controllers\Admin\CustomerController::class, 'destroy'])->name('sales.destroy');

});
