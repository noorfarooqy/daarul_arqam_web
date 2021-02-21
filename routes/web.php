<?php

use App\Http\Controllers\TrendingContentController;
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
        Route::get('/category', 'MainController@openCategoryPage');
        Route::get('/category/{cat_id}', 'MainController@openBooksFromCategory');
        Route::post('/category', 'MainController@AddCategoryBook');
    });
    Route::prefix('casharada')->group(function () {
        Route::get('/new/{book_id}', 'MainController@AddLessonForm');
        Route::get('/list', 'MainController@ListLesson');
        Route::get('/edit/{book_id}/{lesson_id}', 'MainController@EditLessonForm');
        // Route::post('/new/{book_id}', 'MainController@AddLessonToDB');
    });
    Route::prefix('muxaadaro')->group(function () {
        Route::get('/new', 'MainController@AddSermonForm');
        Route::get('/list', 'MainController@ListSermons');
    });
    Route::prefix('trend')->group(function () {
        Route::get('/', [TrendingContentController::class, 'viewTrendForm']);
        Route::get('/list', [TrendingContentController::class, 'viewTrendList']);
    });
});

Auth::routes(['register' => env('registration_status', true)]);
