<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalculateController;

Route::name('api.')->group(function () {
    Route::name('v1.')->group(function () {
        Route::group(['prefix' => 'v1'], function () {
            Route::group(['prefix' => 'wjc'], function () {
                Route::post('/evaluate', [CalculateController::class, 'evaluate'])->name('evaluate');
            });
        });
    });
});
