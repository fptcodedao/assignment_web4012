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


        Route::group(['prefix' => 'category', 'as' =>'category.'], function(){
            Route::post('data', 'CategoryController@data')->name('data');
            Route::post('search', 'CategoryController@search')->name('search');

            Route::resource('', 'CategoryController')->parameters([
                '' => 'category?'
            ])->except(['create', 'edit']);
        });

        Route::group(['prefix' => 'posts', 'as' => 'posts.'], function(){

            Route::post('data', 'PostController@data')->name('data');
            Route::resource('', 'PostController')->parameters([
                '' => 'posts?'
            ]);
        });
    });
});
