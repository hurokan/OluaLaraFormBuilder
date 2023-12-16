<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web']], function () {
    Route::get('/build/single-form/', [\rokan\olualaraformbuilder\SingleFormBuilderController::class, 'buildSingleForm'])->name('build.single-form');
    Route::post('/submit/single-form/', [\rokan\olualaraformbuilder\SingleFormBuilderController::class, 'submitSingleForm'])->name('single-form.submit');
});
