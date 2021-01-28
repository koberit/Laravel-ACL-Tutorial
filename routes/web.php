<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('permissions', 'App\Http\Controllers\PermissionController')->middleware('permissions:administrator');
Route::resource('users', 'App\Http\Controllers\UserController')->middleware('permissions:administrator');
Route::resource('groups', 'App\Http\Controllers\GroupController')->middleware('permissions:administrator');

Route::get('/posts', [PostController::class,'index'])->name('posts.index');
Route::get('/posts/create', [PostController::class,'create'])->name('posts.create')->middleware('permissions:posts-create');
Route::post('/posts', [PostController::class,'store'])->name('posts.store')->middleware('permissions:posts-create');
