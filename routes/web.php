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


Route::get('info', function () {
    return phpinfo();
});

Route::middleware('auth')->group(function () {
    Route::get('/', 'MainController@OpenIndexPage');
    Route::prefix('sheekh')->group(function () {
        Route::get('/new', 'MainController@AddSheekhForm');
        Route::get('/list', 'MainController@ListSheekhs');
        Route::post('/new', 'MainController@AddSheekhToDB');
    });
    Route::prefix('books')->group(function () {
        Route::get('/new', 'MainController@AddBookForm');
        Route::get('/list', 'MainController@ListBooks');
        Route::post('/new', 'MainController@AddBookToDB');
    });
    Route::prefix('casharada')->group(function () {
        Route::get('/new/{book_id}', 'MainController@AddLessonForm');
        Route::get('/list', 'MainController@ListLesson');
        Route::post('/new/{book_id}', 'MainController@AddLessonToDB');
    });
});

Auth::routes(['register' => true]);
