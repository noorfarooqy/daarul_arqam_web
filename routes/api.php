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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/sheekhs', 'MainController@openAPIGetSheekhList');
Route::post('/sheekhs/{sheekh_id}', 'MainController@openAPIGetGivenSheekh');
Route::post('/books', 'MainController@openAPIGetBooksList');
Route::post('/books/{book_id}', 'MainController@openAPIGetGivenBook');
Route::post('/lessons', 'MainController@openAPIGetLessonsList');
