<?php

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
});

Route::post('/sheekhs', 'MainController@openAPIGetSheekhList');
Route::post('/sheekhs/{sheekh_id}', 'MainController@openAPIGetGivenSheekh');
Route::post('/books', 'MainController@openAPIGetBooksList');
Route::post('/books/{book_id}', 'MainController@openAPIGetGivenBook');
Route::post('/lessons', 'MainController@openAPIGetLessonsList');
Route::post('/sermons', 'MainController@openAPISermonsList');
