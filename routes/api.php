<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TypeController;


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

Route::apiResource("/projects", ProjectController::class)->only(["index", "show"]);

Route::get("/projects-by-type/{type_id}", [ProjectController::class, 'projectsByType']);

Route::apiResource("types", TypeController::class)->only(["show"]);

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//  return $request->user();
//});