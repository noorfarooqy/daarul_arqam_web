<?php

use App\Http\Controllers\TrendingContentController;
use Illuminate\Http\Request;
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

    Route::post('/lesson/new/{book_id}', 'MainController@AddLessonToDB');
    Route::post('/muxaadaro/new', 'MainController@AddSermonToDB');
    Route::post('/lesson/edit', 'MainController@EditLesson');
    Route::post('/trending', [TrendingContentController::class, 'createOrUpdateTrendingContent']);
});

// Route::post('/trending', [TrendingContentController::class, 'createOrUpdateTrendingContent'])->middleware('web');

Route::post('/sheekhs', 'MainController@openAPIGetSheekhList');
Route::post('/sheekhs/{sheekh_id}', 'MainController@openAPIGetGivenSheekh');
Route::post('/books', 'MainController@openAPIGetBooksList');
Route::post('/books/{book_id}', 'MainController@openAPIGetGivenBook');
Route::post('/lessons', 'MainController@openAPIGetLessonsList');
Route::post('/sermons', 'MainController@openAPISermonsList');
Route::post('/categories', 'MainController@getCategoriesList');
Route::post('/sheekhs/categories/{sheekh_id}', 'MainController@openAPIGetSheekhBookCategories');
Route::post('/sheekhs/category/{sheekh_id}/{category_id}', 'MainController@openAPIgetGivenSheekhCategoryBooks');
Route::post('/trending/active', [TrendingContentController::class, 'getActiveTrend']);
Route::post('/trending/{trend_id}', [TrendingContentController::class, 'getTrendingContentDetail']);
