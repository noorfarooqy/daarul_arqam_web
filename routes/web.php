<?php

use App\Http\Controllers\MainController;
use App\Http\Controllers\TrendingContentController;
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

Route::get('info', function () {
    return phpinfo();
});

Route::middleware('auth')->group(function () {
    Route::controller(MainController::class)->group(function () {
        Route::get('/', 'OpenIndexPage');

        Route::prefix('sheekh')->group(function () {
            Route::get('/new', 'AddSheekhForm');
            Route::get('/list', 'ListSheekhs');
            Route::post('/new', 'AddSheekhToDB');

        });
        Route::prefix('books')->group(function () {
            Route::prefix('/{book_id}/lessons')->group(function () {
                Route::get('/', 'viewBookLessons');
                Route::get('/new', 'AddLessonForm');
            });
            Route::get('/new', 'AddBookForm');
            Route::get('/list', 'ListBooks');
            Route::post('/new', 'AddBookToDB');
            Route::get('/category', 'openCategoryPage');
            Route::get('/category/{cat_id}', 'openBooksFromCategory');
            Route::post('/category', 'AddCategoryBook');
        });
        Route::prefix('casharada')->group(function () {
            Route::get('/new/{book_id}', 'AddLessonForm');
            Route::get('/list', 'ListLesson');
            Route::get('/edit/{book_id}/{lesson_id}', 'EditLessonForm');
            Route::get('/list/{book_id}', 'viewBookLessons');

            // Route::post('/new/{book_id}', 'AddLessonToDB');
        });
        Route::prefix('muxaadaro')->group(function () {
            Route::get('/new', 'AddSermonForm');
            Route::get('/list', 'ListSermons');
        });
        Route::prefix('trend')->group(function () {
            Route::get('/', [TrendingContentController::class, 'viewTrendForm']);
            Route::get('/list', [TrendingContentController::class, 'viewTrendList']);
        });

    });

});

Auth::routes(['register' => env('registration_status', true)]);
