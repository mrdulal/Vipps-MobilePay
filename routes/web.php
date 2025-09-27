<?php

use Illuminate\Support\Facades\Route;
use Mrdulal\LaravelVipps\Http\Controllers\WebhookController;

/*
|--------------------------------------------------------------------------
| Vipps Package Routes
|--------------------------------------------------------------------------
|
| These routes are loaded by the VippsServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('vipps')->name('vipps.')->group(function () {
    Route::post('webhook', [WebhookController::class, 'handle'])->name('webhook');
});