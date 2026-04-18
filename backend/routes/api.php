<?php

use App\Http\Controllers\Api\AiController;
use App\Http\Controllers\Api\SystemController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/health', [SystemController::class, 'health']);
Route::get('/status', [SystemController::class, 'status']);
Route::post('/ai/chat', [AiController::class, 'chat']);
