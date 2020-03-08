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

    Route::get('logout', function(){
        \Auth::guard('admin')->logout();
        return redirect()->route('dashboard.login.index');
    })->name('logout');


    Route::group(['middleware' => 'admin_auth'], function (){
        Route::get('/', function(){
            return view('admin.index');
        })->name('index');


        Route::group(['prefix' => 'category', 'as' =>'category.'], function(){
            Route::post('data', 'CategoryController@data')->name('data');
            Route::post('search', 'CategoryController@search')->name('search');

            Route::resource('', 'CategoryController')->parameters([
                '' => 'category?'
            ])->except(['create', 'edit']);
        });

        Route::group(['prefix' => 'posts', 'as' => 'posts.'], function(){

            Route::post('data', 'PostsController@data')->name('data');
            Route::resource('', 'PostsController')->parameters([
                '' => 'posts?'
            ])->except(['show']);
        });


        Route::group(['prefix' => 'users', 'as' => 'users.'], function(){
            Route::post('data', 'UsersController@data')->name('data');
            Route::resource('', 'UsersController')->parameters([
                '' => 'users?'
            ])->except([
                'show', 'edit', 'update', 'create'
            ]);
        });

        Route::group(['prefix' => 'comments', 'as' => 'comments.'], function(){
            Route::post('data', 'CommentController@data')->name('data');

            Route::resource('', 'CommentController')->parameters([
                '' => 'comments?'
            ])->only([
                'index', 'destroy'
            ]);
        });

        Route::group(['prefix' => 'roles', 'as' => 'roles.'], function (){
            Route::resource('', 'RoleController')->parameters([
                '' => 'roles?'
            ])->except([
                'show', 'create', 'delete',

            ]);
        });

        Route::group(['prefix' => 'admin', 'as' => 'admin.'], function (){
            Route::resource('', 'AdminController')->parameters([
                '' => 'admin?'
            ])->except([
                'show', 'create'
            ]);
        });
    });
});
