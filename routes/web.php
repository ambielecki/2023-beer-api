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

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::group(['prefix' => 'admin'], function () {
    Route::get('/', 'AdminHomeController@index')->name('home');

    Route::group(['middleware' => ['auth', 'admin']], function () {
        Route::get('test', 'TestController@getTest');
        Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

        Route::group(['prefix' => '/users'], function () {
            Route::get('/', 'AdminUserController@getList')->name('user_list');
            Route::get('/password', 'AdminUserController@getPassword')->name('user_password');
            Route::post('/password', 'AdminUserController@postPassword');
            Route::get('/edit/{user_id}', 'AdminUserController@getEdit')->name('user_edit');
            Route::post('/edit/{user_id}', 'AdminUserController@postEdit');

            Route::get('/ajax-list', 'AdminUserController@getAjaxList');
        });

        Route::group(['prefix' => '/events'], function () {
            Route::get('/', 'AdminEventController@getList')->name('event_list');
            Route::get('/create', 'AdminEventController@getCreate')->name('event_create');
            Route::post('/create', 'AdminEventController@postCreate');
            Route::get('/edit/{event_id}', 'AdminEventController@getEdit')->name('event_edit');
            Route::post('/edit/{event_id}', 'AdminEventController@postEdit');
        });

        Route::group(['prefix' => '/pages'], function () {
            Route::get('/', 'AdminPageController@getList')->name('page_list');
            Route::get('/create', 'AdminPageController@getCreate')->name('page_create');
            Route::post('/create', 'AdminPageController@postCreate');
            Route::get('/edit/{page_id}', 'AdminPageController@getEdit')->name('page_edit');
            Route::post('/edit/{page_id}', 'AdminPageController@postEdit');
        });

        Route::group(['prefix' => '/groups'], function () {
            Route::get('/', 'AdminGroupController@getList')->name('group_list');
            Route::get('/create', 'AdminGroupController@getCreate')->name('group_create');
            Route::post('/create', 'AdminGroupController@postCreate');
            Route::get('/edit/{group_id}', 'AdminGroupController@getEdit')->name('group_edit');
            Route::post('/edit/{group_id}', 'AdminGroupController@postEdit');
        });

        Route::group(['prefix' => '/locations'], function () {
            Route::get('/', 'AdminLocationController@getList')->name('location_list');
            Route::get('/create', 'AdminLocationController@getCreate')->name('location_create');
            Route::post('/create', 'AdminLocationController@postCreate');
            Route::get('/edit/{location_id}', 'AdminLocationController@getEdit')->name('location_edit');
            Route::post('/edit/{location_id}', 'AdminLocationController@postEdit');
        });
    });
});
