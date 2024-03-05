<?php

use Illuminate\Support\Facades\Route;
use  Iomanager\Swgenerator\SwaggerManager;
use Iomanager\Swgenerator\SwagController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/info_table',[\App\Http\Controllers\SwaggerController::class,'generateAnnotations']);


Route::get('/IoSwagGen', [SwagController::class,'generateAnnotations']);

