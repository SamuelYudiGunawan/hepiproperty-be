<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Listing\CreateListingController;
use App\Http\Controllers\Listing\GetAllListingController;
use App\Http\Controllers\Listing\UpdateListingController;
use Illuminate\Foundation\Console\RouteListCommand;
use Illuminate\Routing\RouteGroup;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['prefix'=>'/auth'], function () {
    Route::post('/register', [AuthController::class, 'Register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware(['auth:sanctum']);
});

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::group(['prefix'=>'/property'], function () {
        Route::post('/create', [PropertyController::class, 'create']);
        Route::get('/get-all', [PropertyController::class, 'getAll']);
        Route::get('/get/{id}', [PropertyController::class, 'get']);
        Route::put('/update/{id}', [PropertyController::class, 'update']);
        Route::delete('/delete/{id}', [PropertyController::class, 'delete']);
    });
});

Route::get('/token-invalid', function () {
    return response()->json([
        'message' => 'Invalid Credentials',
        'status'  => 'error'
    ], 400);
})->name('login');
Route::post('/listing', CreateListingController::class);
Route::get('/get-all-listing', GetAllListingController::class);
Route::put('/listings/{id}', UpdateListingController::class);
Route::delete('/listings/{id}', UpdateListingController::class);