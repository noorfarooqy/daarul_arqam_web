<?php

use App\Http\Controllers\MainController;
use App\Http\Controllers\TrendingContentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::middleware('auth:api')->group(function () {

    Route::controller(MainController::class)->group(function () {
        Route::post('/lesson/new/{book_id}', 'AddLessonToDB');
        Route::post('/muxaadaro/new', 'AddSermonToDB');
        Route::post('/lesson/edit', 'EditLesson');

    });

    Route::controller(TrendingContentController::class)->group(function () {
        Route::post('/trending', 'createOrUpdateTrendingContent');
    });
});

// Route::post('/trending', [TrendingContentController::class, 'createOrUpdateTrendingContent'])->middleware('web');

Route::controller(MainController::class)->group(function () {

    Route::get('/sheekhs', 'openAPIGetSheekhList');
    Route::post('/sheekhs/{sheekh_id}', 'openAPIGetGivenSheekh');
    Route::get('/books', 'openAPIGetBooksList');
    Route::post('/books/{book_id}', 'openAPIGetGivenBook');
    Route::get('/lessons', 'openAPIGetLessonsList');
    Route::get('/sermons', 'openAPISermonsList');
    Route::post('/categories', 'getCategoriesList');
    Route::post('/sheekhs/categories/{sheekh_id}', 'openAPIGetSheekhBookCategories');
    Route::post('/sheekhs/category/{sheekh_id}/{category_id}', 'openAPIgetGivenSheekhCategoryBooks');

});

Route::controller(TrendingContentController::class)->group(function () {

    Route::post('/trending/active', 'getActiveTrend');
    Route::post('/trending/{trend_id}', 'getTrendingContentDetail');

});
