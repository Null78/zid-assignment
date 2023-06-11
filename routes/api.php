<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\ItemStatisticsController;
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

Route::get('statistics/items', ItemStatisticsController::class)->name('items.statistics');

Route::apiResource('items', ItemController::class)->only(['index', 'store', 'show', 'update']);
