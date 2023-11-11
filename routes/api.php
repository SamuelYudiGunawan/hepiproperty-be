<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Foundation\Console\RouteListCommand;
use App\Http\Controllers\Properties\PropertyController;
use App\Http\Controllers\Listing\CreateListingController;
use App\Http\Controllers\Listing\GetAllListingController;
use App\Http\Controllers\Listing\UpdateListingController;
use App\Models\Property;

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

Route::group(['prefix'=>'/auth'], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware(['auth:sanctum']);
});

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::group(['prefix'=>'/admin', 'middleware'=>['role:admin|owner']], function () {
        Route::post('/user/create/{role}', [AuthController::class, 'register']);
    });
    Route::group(['prefix'=>'/agent', 'middleware'=>['role:admin|owner|agent']], function () {
        Route::get('/property/list', [PropertyController::class, 'getPaginateByAgent']);
    });
    Route::group(['prefix'=>'/property'], function () {
        Route::group(['middleware' => ['role:owner|admin|agent']], function () {
            Route::post('/create', [PropertyController::class, 'create']);
            Route::post('/update/id/{id}', [PropertyController::class, 'update']);
            Route::post('/delete/id/{id}', [PropertyController::class, 'delete']);
        });

    });
});

Route::get('/token-invalid', function () {
    return response()->json([
        'message' => 'Invalid Credentials',
        'status'  => 'error'
    ], 400);
})->name('login');
Route::get('/property/list', [PropertyController::class, 'getPaginate']);
Route::get('/property/detail/id/{id}', [PropertyController::class, 'detail']);
Route::post('/property/filter', [PropertyController::class, 'searchFilter']);