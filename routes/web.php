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

Route::redirect('/','sudokoo/list/sudoku');

Route::group(['middleware' => 'not.blocked'], function() {
    //SudokuGrid routes
    Route::get('/sudokoo/list/sudoku', 'App\Http\Controllers\SudokuController@index')->name('sudoku.list');
    Route::get('/sudokoo/sudoku/{id}','App\Http\Controllers\SudokuController@show')->name('sudoku.show');
    Route::get('/sudokoo/create/sudoku','App\Http\Controllers\SudokuController@create')->name('sudoku.create')->middleware(['auth']);
    Route::post('/sudokoo/create/sudoku', 'App\Http\Controllers\SudokuController@store')->name('sudoku.store')->middleware('auth');
    Route::get('/sudokoo/edit/sudoku/{id}','App\Http\Controllers\SudokuController@edit')->name('sudoku.edit')->middleware(['auth']);
    Route::post('/sudokoo/edit/sudoku/{id}','App\Http\Controllers\SudokuController@update')->name('sudoku.update')->middleware('auth');
    Route::get('/sudokoo/destroy/sudoku/{id}','App\Http\Controllers\SudokuController@destroy')->name('sudoku.destroy')->middleware(['auth']);

//Rating routes
   Route::post('/sudokoo/create/rating/{id}', 'App\Http\Controllers\RatingController@store')->name('rating.store')->middleware(['auth']);
   Route::post('/sudokoo/edit/rating/{id}','App\Http\Controllers\RatingController@update')->name('rating.update')->middleware(['auth']);

//Comment routes
    Route::post('/sudokoo/create/comment/{id}', 'App\Http\Controllers\CommentController@store')->name('comment.store')->middleware(['auth']);
    Route::post('/sudokoo/edit/comment/{id}','App\Http\Controllers\CommentController@update')->name('comment.update')->middleware(['auth']);
    Route::get('/sudokoo/destroy/comment/{id}','App\Http\Controllers\CommentController@destroy')->name('comment.destroy')->middleware(['auth']);
    Route::get('/sudokoo/report/comment/{id}','App\Http\Controllers\CommentController@report')->name('comment.report')->middleware(['auth']);
    Route::get('/sudokoo/list/reported', 'App\Http\Controllers\CommentController@reportIndex')->name('report.index')->middleware(['auth','admin']);
    Route::get('/sudokoo/report/remove/{id}', 'App\Http\Controllers\CommentController@removeReport')->name('report.remove')->middleware(['auth','admin']);

//User routes
    Route::get('/sudokoo/list/user', 'App\Http\Controllers\UserController@index')->name('user.list')->middleware(['auth','admin']);
    Route::get('/sudokoo/user/{id}','App\Http\Controllers\UserController@show')->name('user.show')->middleware(['auth','auth.user']);
    Route::get('/sudokoo/edit/user/{id}','App\Http\Controllers\UserController@edit')->name('user.edit')->middleware(['auth','auth.user']);
    Route::post('sudokoo/edit/user/{id}', 'App\Http\Controllers\UserController@update')->name('user.update')->middleware(['auth','auth.user']);
    Route::get('/sudokoo/edit/userPass/{id}','App\Http\Controllers\UserController@editPassword')->name('password.edit')->middleware(['auth','auth.user']);
    Route::post('sudokoo/edit/userPass/{id}', 'App\Http\Controllers\UserController@updatePassword')->name('password.change')->middleware(['auth','auth.user']);
    Route::get('/sudokoo/role/user/{id}','App\Http\Controllers\UserController@editRole')->name('role.edit')->middleware(['auth','admin']);
    Route::post('/sudokoo/role/user', 'App\Http\Controllers\UserController@updateRole')->name('role.update')->middleware(['auth','admin']);

//Blocking routes
    Route::get('/sudokoo/create/blocking/{id}', 'App\Http\Controllers\BlockingController@create')->name('blocking.create')->middleware(['auth', 'admin']);
    Route::post('/sudokoo/create/blocking','App\Http\Controllers\BlockingController@store')->name('blocking.store')->middleware(['auth','admin']);
});

Route::get('/sudokoo/blocked','App\Http\Controllers\BlockingController@showBlocked')->name('blocking.showScreen')->middleware(['auth']);
