<?php

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

Auth::routes();

//returns main view of personal web page
//Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


//Redirects 'sudokoo/' to 'sudokoo/sudokoo/list/sudoku' ('sudokoo' is the vhost used during development)
Route::redirect('/','sudokoo/list/sudoku');

//SudokuGrid routes
Route::resource('sudokoo','App\Http\Controllers\SudokuController')->except('index','show','create','store','edit','update','destroy');
Route::get('/sudokoo/list/sudoku', 'App\Http\Controllers\SudokuController@index')->name('sudoku.list');
Route::get('/sudokoo/sudoku/{id}','App\Http\Controllers\SudokuController@show')->name('sudoku.show');
Route::get('/sudokoo/create/sudoku','App\Http\Controllers\SudokuController@create')->name('sudoku.create')->middleware(['auth','not.blocked']);
Route::post('/sudokoo/create/sudoku', 'App\Http\Controllers\SudokuController@store')->name('sudoku.store')->middleware('auth');
Route::get('/sudokoo/edit/sudoku/{id}','App\Http\Controllers\SudokuController@edit')->name('sudoku.edit')->middleware(['auth','not.blocked']);
Route::post('/sudokoo/edit/sudoku/{id}','App\Http\Controllers\SudokuController@update')->middleware('auth');
Route::get('/sudokoo/destroy/sudoku/{id}','App\Http\Controllers\SudokuController@destroy')->name('sudoku.destroy')->middleware(['auth','not.blocked']);
//Route::post('/sudokoo/search/sudoku', 'App\Http\Controllers\SudokuController@postSearch')->name('sudoku.search')->middleware(['auth','not.blocked']);

//User routes
Route::resource('users','App\Http\Controllers\UserController')->except('index','show','create','store','edit','update','destroy');
Route::get('/sudokoo/list/user', 'App\Http\Controllers\UserController@index')->name('user.list')->middleware(['auth','not.blocked','admin']);
Route::get('/sudokoo/user/{id}','App\Http\Controllers\UserController@show')->name('user.show')->middleware(['auth','not.blocked']);
//Route::get('/sudokoo/create/user', 'App\Http\Controllers\UserController@create')->name('user.create');
Route::post('/sudokoo/create/user','App\Http\Controllers\UserController@store')->middleware(['auth','not.blocked']);
Route::get('/sudokoo/edit/user/{id}','App\Http\Controllers\UserController@edit')->name('user.edit')->middleware(['auth','not.blocked','auth.user']);
Route::patch('sudokoo/edit/user/{id}', 'App\Http\Controllers\UserController@update')->name('user.update')->middleware(['auth','not.blocked','auth.user']);
Route::get('/sudokoo/edit/userPass/{id}','App\Http\Controllers\UserController@editPassword')->name('password.edit')->middleware(['auth','not.blocked','auth.user']);
Route::patch('sudokoo/edit/userPass/{id}', 'App\Http\Controllers\UserController@updatePassword')->name('password.change')->middleware(['auth','not.blocked','auth.user']);
//Route::get('/sudokoo/destroy/user/{id}', 'App\Http\Controllers\UserController@destroy')->name('user.destroy')->middleware(['auth','not.blocked','auth.user']);
//Route::post('/sudokoo/search/user', 'App\Http\Controllers\UserController@postSearch')->name('user.search')->middleware(['auth','not.blocked']);
Route::get('/sudokoo/role/user/{id}','App\Http\Controllers\UserController@editRole')->name('role.edit')->middleware(['auth','not.blocked', 'admin']);
Route::post('/sudokoo/role/user', 'App\Http\Controllers\UserController@updateRole')->name('role.update')->middleware(['auth','not.blocked', 'admin']);


//Blocking routes
Route::resource('blocking', 'App\Http\Controllers\BlockingController')->except('create','store');
Route::get('/sudokoo/create/blocking/{id}', 'App\Http\Controllers\BlockingController@create')->name('blocking.create')->middleware(['auth','not.blocked', 'admin']);
Route::post('/sudokoo/create/blocking','App\Http\Controllers\BlockingController@store')->name('blocking.store')->middleware(['auth','not.blocked', 'admin']);

Route::get('/sudokoo/blocked','App\Http\Controllers\BlockingController@showBlocked')->name('blocking.showScreen')->middleware(['auth']);
