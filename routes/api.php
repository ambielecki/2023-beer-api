<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/health-check', [Controllers\ApiTestController::class, 'getHealthCheck']);
Route::get('/echo', [Controllers\ApiTestController::class, 'echo']);
Route::post('/register', [Controllers\ApiAuthController::class, 'postRegister']);
Route::post('/login', [Controllers\ApiAuthController::class, 'postLogin']);
Route::post('/logout', [Controllers\ApiAuthController::class, 'postLogout']);
Route::post('/refresh', [Controllers\ApiAuthController::class, 'postRefresh']);

Route::group(['middleware' => ['auth:api']], function () {
    Route::get('/user', [Controllers\ApiUserController::class, 'getUser']);
    Route::post('/password', [Controllers\ApiUserController::class, 'postResetPassword']);
    Route::post('/logout', [Controllers\ApiAuthController::class, 'postLogout']);
});

Route::group(['prefix' => 'beer'], function () {
    Route::get('/', [Controllers\ApiBeerController::class, 'getList']);

    Route::get('/home', [Controllers\ApiBeerController::class, 'getHomePage']);
    Route::get('/styles', [Controllers\ApiBeerController::class, 'getStyles']);
    Route::get('/{id}', [Controllers\ApiBeerController::class, 'getBeer']);

    Route::group(['middleware' => ['auth:api']], function () {
        Route::post('/', [Controllers\ApiBeerController::class, 'postBeer']);
        Route::put('/{id}', [Controllers\ApiBeerController::class, 'updateBeer']);
        Route::delete('/{id}', [Controllers\ApiBeerController::class, 'deleteBeer']);
    });
});

Route::fallback([Controllers\ApiFallBackController::class, 'getFallBack']);
