<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MobilController;
use App\Http\Controllers\MotorController;
use App\Http\Controllers\PenjualanMobilController;
use App\Http\Controllers\PenjualanMotorController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});


Route::group(['middleware' => 'auth:api'], function () {
    Route::get("user", [UserController::class, "index"]);
    Route::prefix('{type}')->group(function () {
        Route::get('stok', [VehicleController::class, 'stok']);
        Route::get('stok/{id}', [VehicleController::class, 'stokById']);
        Route::post('sale', [VehicleController::class, 'storeSales']);
        Route::get('report', [VehicleController::class, 'report']);
        Route::get('report/{id}', [VehicleController::class, 'reportById']);
    });
});
