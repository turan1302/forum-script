<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix'=>'sitemap','namespace'=>'API'],function (){
    Route::get('',[\App\Http\Controllers\API\indexController::class,'sitemap']);
    Route::get('kategoriler',[\App\Http\Controllers\API\indexController::class,'kategoriler'])->name('kategoriler');
    Route::get('etiketler',[\App\Http\Controllers\API\indexController::class,'etiketler'])->name('etiketler');
    Route::get('uyeler',[\App\Http\Controllers\API\indexController::class,'uyeler'])->name('uyeler');
});
