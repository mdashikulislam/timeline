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

Route::get('/', [\App\Http\Controllers\MainController::class,'index']);
Route::post('add-timeline',[\App\Http\Controllers\MainController::class,'store'])->name('store');
Route::get('delete-timeline/{id}',[\App\Http\Controllers\MainController::class,'delete'])->name('delete');
Route::post('edit-data',[\App\Http\Controllers\MainController::class,'editData'])->name('edit-data');
Route::post('update-data',[\App\Http\Controllers\MainController::class,'update'])->name('update-data');
Route::get('delete-attachment/{id}',[\App\Http\Controllers\MainController::class,'deleteAttachment'])->name('delete-attachment-data');
