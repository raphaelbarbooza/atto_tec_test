<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();

Route::get('/',function (){
    return redirect(route('home'));
});

Route::middleware('auth:web')->group(function(){
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::prefix('producers')->group(function(){
        Route::view('/','pages.manage-producers')->name('manage.producers');
        // Get a producer
        Route::prefix('{producer}')->group(function(){
           Route::get('/',[\App\Http\Controllers\ProducersController::class,'manage'])->name('manage.producers.farms');
        });
    });

    Route::get('/logoff',function(){
       \Illuminate\Support\Facades\Auth::logout();
       return redirect()->route('login');
    })->name('logoff');
});



