<?php

use App\Http\Controllers\ProductsController;
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


 Route::resource('products', ProductsController::class);
//Route::get('/prod',[ProductsController::class,'store']);

//if you need specify type Route::get('contacts/{id:[0-9]+}', 'ContactController@get_contact'); OR Route::get('contacts/{id:[A-Za-z]+}', 'ContactController@get_contact');
 //Route::get('/altro/{id}/{name}', [ProductsController::class,'myMethod']);

 //Route::get('/getProduct/{stock}', [ProductsController::class,'myMethod2']);

Route::get('/getProduct/{stock}/',[ProductsController::class,'myMethod2']);

/* Generate a route with a query string using the route() function */



