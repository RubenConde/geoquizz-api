<?php

use App\Http\Controllers\Api\BaseController;
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

Route::group(['middleware' => ['json.response']], function () {
    Route::group(['middleware' => ['cors']], function () {
        Route::prefix('v1')->group(function () {
            Route::get('/', function () {
                $status = [
                    "version" => "1.0",
                    "online" => true
                ];
                $baseController = new BaseController();
                return $baseController->sendResponse($status, 'GeoQuizz API Status');
            });
            Route::middleware('auth:api')->get('/user', function (Request $request) {
                $baseController = new BaseController();
                return $baseController->sendResponse($request->user(), 'User obtained');
            });
// public routes
            Route::post('login', 'Api\AuthController@login')->name('login.api');
            Route::post('register', 'Api\AuthController@register')->name('register.api');
            Route::get('games', 'GameController@index')->name('games');
            Route::get('games/{game}', 'GameController@show')->name('game');
            Route::post('games', 'GameController@store')->name('createGame');
            Route::put('games/{game}', 'GameController@update')->name('editGame');

            Route::get('difficulties', 'DifficultyController@index')->name('difficulties');
            Route::get('difficulties/{difficulty}', 'DifficultyController@show')->name('difficulty');

            Route::get('photos', 'PhotoController@index')->name('photos');
            Route::get('photos/{photo}', 'PhotoController@show')->name('photo');

            Route::get('series', 'SeriesController@index')->name('series');
            Route::get('series/{series}', 'SeriesController@show')->name('aSeries');

// private routes
            Route::middleware('auth:api')->group(function () {
                Route::get('logout', 'Api\AuthController@logout')->name('logout');

                Route::delete('games/{game}', 'GameController@destroy')->name('deleteGame');

                Route::post('difficulties', 'DifficultyController@store')->name('createDifficulty');
                Route::put('difficulties/{difficulty}', 'DifficultyController@update')->name('editDifficulty');
                Route::delete('difficulties/{difficulty}', 'DifficultyController@destroy')->name('deleteDifficulty');

                Route::post('photos', 'PhotoController@store')->name('createPhoto');
                Route::put('photos/{photo}', 'PhotoController@update')->name('editPhoto');
                Route::delete('photos/{photo}', 'PhotoController@destroy')->name('deletePhoto');

                Route::post('series', 'SeriesController@store')->name('createSeries');
                Route::put('series/{series}', 'SeriesController@update')->name('editSeries');
                Route::delete('series/{series}', 'SeriesController@destroy')->name('deleteSeries');
            });
        });
    });
});
