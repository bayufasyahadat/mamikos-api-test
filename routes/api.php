<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KostController;
use App\Http\Controllers\TransactionController;

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

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    //Logout
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    
    //Kost Endpoint for Owner
    Route::post('/kost/register', [KostController::class, 'createKost']);
    Route::get('/kost/getmykost', [KostController::class, 'getKostbyIdOwner']);
    Route::put('/kost/edit/{id}', [KostController::class, 'updateKost']);
    Route::delete('/kost/delete/{id}', [KostController::class, 'deleteKost']);

    //availability
    Route::get('/transaction/availability', [TransactionController::class, 'getAvailabilityStatus']);
    Route::post('/kost/availability/ask/{kostId}', [TransactionController::class, 'askAvailabilityStatus']);
    Route::post('/kost/availability/confirm/{kostId}', [TransactionController::class, 'confirmAvailabilityStatus']);
    

});

Route::get('/kost/get/{id}', [KostController::class, 'detailKost']); //get kost detail
Route::get('/kost/get', [KostController::class, 'index']);