<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [\App\Http\Controllers\ChartController::class, 'index']);

Route::get('/chart', [\App\Http\Controllers\ChartController::class, 'chart']);
Route::get('/check', function(){
   \Illuminate\Support\Facades\Artisan::call('import:web');
});
