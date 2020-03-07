<?php

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
use Illuminate\Support\Facades\Route;

Auth::routes(['verify' => true]);

Route::group(['as' => 'client.'], function(){
    Route::get('/', 'HomeController@index')->name('index');

    Route::group(['prefix' => 'p', 'as' => 'posts.'], function (){

        Route::group(['middleware' => ['verified']], function (){
            Route::post('comment/{slug}', 'PostController@storeComment')
                ->name('comment');
        });
        Route::resource('', 'PostController')->parameters([
            '' => 'posts?'
        ])->except([
            'store', 'create', 'destroy'
        ]);
    });

    Route::group(['prefix' => 'account', 'as' => 'account.', 'middleware' => ['verified']], function(){
        Route::post('password/{id}', 'AccountController@storePassword')->name('password');
        Route::resource('', 'AccountController')->parameters([
            '' => 'account?'
        ])->except([
            'show', 'edit', 'destroy', 'store', 'create'
        ]);
    });

    Route::group(['prefix' => 'category', 'as' => 'category.'], function (){
        Route::resource('', 'CategoryController')->parameters([
            '' => 'category?'
        ])->except([
            'store', 'create', 'destroy', 'index'
        ]);
    });
});
