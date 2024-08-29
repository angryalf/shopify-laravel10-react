<?php

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

Route::any('webhooks', function () {
    \Log::debug('Webhook header: '.json_encode(\request()->header()));
    \Log::debug('Webhook: '.json_encode(\request()->toArray()));

    return response()->json([]);
})->middleware(['shopy.webhooks']);
