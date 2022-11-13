<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('auth.layouts.app');
});
Route::name('user.')->group(function () {

    Route::get('/login', function () {
        if (Auth::check()) {
            return redirect(route('products.index'));
        }
        return view('auth.login');
    })->name('login');

    Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'login']);
    Route::post('/logout',function (){
        Auth::logout();
        return redirect('/');
    })->name('logout');
    Route::get('/register', function (){
        if (Auth::check()){
            return redirect(route('products.index'));
        }
        return view('auth.register');
    })->name('register');

    Route::post('/register',[\App\Http\Controllers\Auth\RegisterController::class, 'create']);
});

    Route::resource('products' , \App\Http\Controllers\ProductController::class)->except(['update']);
    Route::post('products/{product}/update', [\App\Http\Controllers\ProductController::class, 'update'])->name('update');

    Route::resource('categories', \App\Http\Controllers\CategoryController::class)->except(['update']);
    Route::post('categories/{category}/update', [\App\Http\Controllers\CategoryController::class, 'update'])->name('category.update');

