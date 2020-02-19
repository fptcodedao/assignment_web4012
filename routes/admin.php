<?php

use Illuminate\Support\Facades\Route;

Route::namespace('Admin')->prefix('dashboard')->name('dashboard.')->group(function (){

    //Route Authenticate
    Route::group(['namespace' => 'Auth', 'middleware' => 'admin_guest'], function(){
        Route::group(['prefix' => 'login', 'as' => 'login.'], function(){

            Route::get('/', 'LoginController@index')->name('index');
            Route::post('/', 'LoginController@login')->name('login');
        });
    });


    Route::group(['middleware' => 'admin_auth'], function (){
        Route::get('/', function(){
            return "a";
        })->name('index');

        Route::resource('category', 'CategoryController');
    });
});
