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

Auth::routes();
Route::middleware('auth')->group(function (){
    Route::get('/', [\App\Http\Controllers\MainController::class,'index']);
    Route::post('add-timeline-item',[\App\Http\Controllers\MainController::class,'store'])->name('store');
    Route::get('delete-timeline/{id}',[\App\Http\Controllers\MainController::class,'delete'])->name('delete');
    Route::post('edit-data',[\App\Http\Controllers\MainController::class,'editData'])->name('edit-data');
    Route::post('update-data',[\App\Http\Controllers\MainController::class,'update'])->name('update-data');
    Route::get('delete-attachment/{id}',[\App\Http\Controllers\MainController::class,'deleteAttachment'])->name('delete-attachment-data');
    Route::post('send-by-email',[\App\Http\Controllers\MainController::class,'sendByEmail'])->name('send-by-email');
    Route::prefix('my-timeline')->controller(\App\Http\Controllers\TimelineController::class)->group(function (){
        Route::post('store','store')->name('timeline.store');
        Route::post('update','update')->name('timeline.update');
        Route::get('delete/{id}','delete')->name('timeline.delete');
    });
    Route::prefix('label')->controller(\App\Http\Controllers\LabelController::class)->group(function (){
        Route::post('store','store')->name('label.store');
        Route::post('update','update')->name('label.update');
        Route::get('delete/{id}','delete')->name('label.delete');
    });
});

Route::get('timeline/{id}',[\App\Http\Controllers\TimelineController::class,'timeline'])->name('shared.timeline');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
