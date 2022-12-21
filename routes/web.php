<?php

use App\Http\Controllers\AboutController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', [AboutController::class, 'index'])->name('about');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('todos/undone', [App\Http\Controllers\TodoController::class, 'undone'])->name('todos.undone');
Route::get('todos/done', [App\Http\Controllers\TodoController::class, 'done'])->name('todos.done');
Route::get('todos/makedone/{todo}', [App\Http\Controllers\TodoController::class, 'makedone'])->name('todos.makedone');
Route::get('todos/makeundone/{todo}', [App\Http\Controllers\TodoController::class, 'makeundone'])->name('todos.makeundone');

Route::resource('todos', 'App\Http\Controllers\TodoController');