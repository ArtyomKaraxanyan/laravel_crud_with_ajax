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

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', [App\Http\Controllers\PostController::class, 'index'])->name('index');
Route::get('/create', [App\Http\Controllers\PostController::class, 'create'])->name('create');
Route::post('/save', [App\Http\Controllers\PostController::class, 'store'])->name('store');
Route::get('/edit/{id}', [App\Http\Controllers\PostController::class, 'edit'])->name('edit');
Route::post('/update/{id}', [App\Http\Controllers\PostController::class, 'update'])->name('update');
Route::post('/learn', [App\Http\Controllers\PostController::class, 'learn'])->name('learn');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('my-form', [App\Http\Controllers\PostController::class, 'myform']);
Route::post('my-form', [App\Http\Controllers\PostController::class, 'myformPost'])->name('my.form');
Route::delete('/my-form/{id}', [App\Http\Controllers\PostController::class, 'destroyform'])->name('deleteform');
Route::get('/my-form/edit/{id}', [App\Http\Controllers\PostController::class, 'editform'])->name('editform');
Route::patch('/my-form/update/{id}', [App\Http\Controllers\PostController::class, 'updateform'])->name('updateform');
