<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;

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

//Route::apiResource("products", ProductsController::class)
//    ->parameters(['id' => 'id_product'])
//    ->only(['show','store','update']);

//Route::Post('/products/{id}', [ProductsController::class,'show']);
//Route::Put('/products/{id}', [ProductsController::class,'update']);

 Route::resource('prods/id', ProductsController::class);


 Route::get('/altro/{id}/{name}', [ProductsController::class,'myMethod']);
