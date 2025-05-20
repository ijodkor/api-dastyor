<?php

use Illuminate\Support\Facades\Route;
use Ijodkor\Dastyor\Http\Controllers\Advanced\CrudController;
use Ijodkor\Dastyor\Http\Controllers\Builders\EnumBuilderController;
use Ijodkor\Dastyor\Http\Controllers\Builders\MigrationBuilderController;
use Ijodkor\Dastyor\Http\Controllers\Builders\ModelBuilderController;
use Ijodkor\Dastyor\Http\Controllers\Builders\RequestBuilderController;
use Ijodkor\Dastyor\Http\Controllers\Builders\ResourceBuilderController;
use Ijodkor\Dastyor\Http\Controllers\ControllerBuilderController;
use Ijodkor\Dastyor\Http\Controllers\MainController;
use Ijodkor\Dastyor\Http\Controllers\MethodBuilderController;
use Ijodkor\Dastyor\Http\Controllers\ServiceBuilderController;

Route::get('/', MainController::class)->name('generator.index');

Route::prefix('/advanced')->as('advanced.')->group(function() {
    Route::get('crud', [CrudController::class, 'create'])->name('crud');
    Route::post('crud', [CrudController::class, 'store'])->name('crud.store');
});

Route::prefix('/builders')->group(function() {
    Route::post('models', ModelBuilderController::class)->name('models.store');
    Route::post('services', ServiceBuilderController::class)->name('services.store');
    Route::post('requests', RequestBuilderController::class)->name('requests.store');
    Route::post('resources', ResourceBuilderController::class)->name('resources.store');
    Route::post('controllers', ControllerBuilderController::class)->name('controllers.store');
    Route::post('methods', MethodBuilderController::class)->name('methods.store');
    Route::post('enums', EnumBuilderController::class)->name('enums.store');
});

// Add extra
Route::get('/migration', MigrationBuilderController::class)->name('migration.builder');

// Catch-all Route...
//Route::get('/{view?}', GeneratorController::class)->where('view', '(.*)')->name('generator.index');