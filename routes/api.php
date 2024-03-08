<?php

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Area\AreaController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Article\ArticleController;
use Illuminate\Foundation\Console\RouteListCommand;
use App\Http\Controllers\Properties\PropertyController;
use App\Http\Controllers\Listing\CreateListingController;
use App\Http\Controllers\Listing\GetAllListingController;
use App\Http\Controllers\Listing\UpdateListingController;
use App\Http\Controllers\Properties\PropertyUnggulanController;

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
        Route::group(['prefix'=>'/user'], function () {
            Route::post('/create', [AuthController::class, 'register']);
            Route::post('/update/id/{id}', [UserController::class, 'update']);
            Route::post('/delete/id/{id}', [UserController::class, 'delete']);
            Route::get('/list', [UserController::class, 'getPaginate']);
            Route::post('/filter', [UserController::class, 'filter']);
        });
    });
    Route::group(['prefix'=>'/agent', 'middleware'=>['role:admin|owner|agent']], function () {
        Route::get('/property/list', [PropertyController::class, 'getPaginateByAgent']);
        Route::post('/property/filter', [PropertyController::class, 'agentPropertyFilter']);
        Route::group(['prefix =>/article'], function () {
            Route::post('/create', [ArticleController::class, 'create']);
            Route::post('/update/id/{id}', [ArticleController::class, 'update']);
            Route::post('/delete/id/{id}', [ArticleController::class, 'delete']);
            Route::get('/list/user', [ArticleController::class, 'getPaginateByUser']);
        });
    });
    Route::group(['prefix'=>'/property'], function () {
        Route::group(['middleware' => ['role:owner|admin|agent']], function () {
            Route::post('/create', [PropertyController::class, 'create']);
            Route::post('/update/id/{id}', [PropertyController::class, 'update']);
            Route::post('/update/id/{id}/with-image-id', [PropertyController::class, 'updateWithImageId']);
            Route::post('/delete/id/{id}', [PropertyController::class, 'delete']);
            Route::post('/add-to-unggulan/id/{id}', [PropertyUnggulanController::class, 'addToUnggulan']);
            Route::post('/remove-from-unggulan/id/{id}', [PropertyUnggulanController::class, 'removeFromUnggulan']);
            Route::post('/set-highlight/id/{id}', [PropertyUnggulanController::class, 'setHighlight']);
            Route::post('/remove-highlight/id/{id}', [PropertyUnggulanController::class, 'removeH   ighlight']);
        });
    });

    Route::post('/profile/update', [UserController::class, 'profileUpdate']);
});

Route::get('/token-invalid', function () {
    return response()->json([
        'message' => 'Invalid Credentials',
        'status'  => 'error'
    ], 400);
})->name('login');
Route::get('/property/list', [PropertyController::class, 'getPaginate']);
Route::group(['prefix'=>'/property'], function () {
    Route::get('/unggulan', [PropertyUnggulanController::class, 'getUnggulan']);
    Route::get('/unggulan/highlight', [PropertyUnggulanController::class, 'getHighlight']);
});
Route::get('/property/newest', [PropertyController::class, 'getNewest']);
Route::get('/property/detail/slug/{slug}', [PropertyController::class, 'detail'])->name('user.property.detail');
Route::post('/property/filter', [PropertyController::class, 'searchFilter']);
Route::get('/property/share/{url}', [PropertyController::class, 'share']);
Route::group(['prefix'=>'/area'], function () {
    Route::get('/semarang', [AreaController::class, 'getSemarang']);
    Route::get('/provinsi', [AreaController::class, 'getProvinsi']);
    Route::get('/provinsi/{id}/kota', [AreaController::class, 'getKota']);
    Route::get('/provinsi/kota/{id}/kecamatan', [AreaController::class, 'getKecamatan']);
    Route::group(['prefix'=>'/detail'], function () {
        Route::get('/provinsi/id/{id}', [AreaController::class, 'provinsiDetail']);
        Route::get('/kota/id/{id}', [AreaController::class, 'kotaDetail']);
        Route::get('/kecamatan/id/{id}', [AreaController::class, 'kecamatanDetail']);
    });
});

Route::group(['user/agent'], function () {
});

Route::get('/list', [ArticleController::class, 'getPaginate']);
Route::post('/filter', [ArticleController::class, 'filter']);

