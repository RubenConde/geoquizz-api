<?php

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

use App\Http\Controllers\Api\BaseController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    $status = [
        "versions" => [
            "v1" => [
                "online" => true,
                "deprecated" => false,
                "maintenance" => false
            ]
        ]
    ];
    $baseController = new BaseController();
    return $baseController->sendResponse($status, 'GeoQuizz API Status');
});
