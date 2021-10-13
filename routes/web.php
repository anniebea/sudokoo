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

//Returns the main laravel welcome page
//Route::get('/', function () {
//    return view('welcome');
//});

Auth::routes();

//returns main view of personal web page
//Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


//Redirects 'sudokoo/' to '/sudokoo' ('sudokoo' is the vhost used during development)
Route::redirect('/','sudokoo');

//Sudoku routes
Route::resource('sudokoo','App\Http\Controllers\SudokuController');
Route::get('/sudokoo/list/sudoku', 'App\Http\Controllers\SudokuController@index')->name('sudoku.list');
Route::get('/sudokoo/sudoku/{id}','App\Http\Controllers\SudokuController@show')->name('sudoku.show');
Route::get('/sudokoo/create/sudoku','App\Http\Controllers\SudokuController@create')->name('sudoku.create')->middleware('auth');
Route::post('/sudokoo/create/sudoku', 'App\Http\Controllers\SudokuController@store')->middleware('auth');
Route::get('/sudokoo/edit/sudoku/{id}','App\Http\Controllers\SudokuController@edit')->name('sudoku.edit')->middleware('auth');
Route::post('/sudokoo/edit/sudoku/{id}','App\Http\Controllers\SudokuController@update')->middleware('auth');
Route::get('/sudokoo/destroy/sudoku/{id}','App\Http\Controllers\SudokuController@destroy')->name('sudoku.destroy')->middleware('auth');
Route::post('/sudokoo/search/sudoku', 'App\Http\Controllers\SudokuController@postSearch')->name('sudoku.search')->middleware('auth');

//User routes
Route::resource('users','App\Http\Controllers\UserController');
Route::get('/sudokoo/list/user', 'App\Http\Controllers\UserController@index')->name('user.list')->middleware('auth');
Route::get('/sudokoo/user/{id}','App\Http\Controllers\UserController@show')->name('user.show')->middleware('auth');
Route::get('/sudokoo/create/user', 'App\Http\Controllers\UserController@create')->name('user.create');
Route::post('/sudokoo/create/user','App\Http\Controllers\UserController@store');
Route::get('/sudokoo/edit/user/{id}','App\Http\Controllers\UserController@edit')->name('user.edit')->middleware('auth');
Route::post('sudokoo/edit/user/{id}', 'App\Http\Controllers\UserController@update')->middleware('auth');
Route::get('/sudokoo/destroy/user/{id}', 'App\Http\Controllers\UserController@destroy')->name('user.destroy')->middleware('auth');
Route::post('/sudokoo/search/user', 'App\Http\Controllers\UserController@postSearch')->name('user.search')->middleware('auth');

Route::get('/sudokoo/user','App\/Http\Controllers\UserController@showProfile')->name('profile.show')->middleware('auth');
