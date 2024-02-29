<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

//Route::get('/clients/{id}', [\App\Http\Controllers\ClientsController::class,'show']);
//
//Route::post('/comune', [\App\Http\Controllers\ClientsController::class,'searchCity']);
//

Route::apiResources([
    'products' => \App\Http\Controllers\ProductsController::class,
]);

Route::get('/altro/{id}/{project_id}', [\App\Http\Controllers\ProductsController::class,'myMethod']);
