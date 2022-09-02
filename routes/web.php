<?php

use App\Http\Controllers\Admin\Auth\LoginController;
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
    return view('welcome');
});

Route::middleware('prevent-back-history')->group(function(){

   
    Route::name('admin.')->controller(LoginController::class)->group(function(){

        Route::middleware('guest')->group(function(){

            Route::get('login','index')->name('login');
            Route::post('login','login')->name('login');

            Route::get('register','register_view')->name('register');
            Route::post('register','register')->name('register');
        });
       

        Route::middleware('auth')->group(function(){

            Route::get('dashboard','dashboard')->name('dashboard');
            Route::get('logout','logout')->name('logout');
        });
    });
});