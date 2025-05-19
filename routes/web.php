<?php

use Illuminate\Support\Facades\Route;
use Uzinfocom\Dastyor\Http\Controllers\Advanced\CrudController;
use Uzinfocom\Dastyor\Http\Controllers\Builders\EnumBuilderController;
use Uzinfocom\Dastyor\Http\Controllers\Builders\MigrationBuilderController;
use Uzinfocom\Dastyor\Http\Controllers\Builders\ModelBuilderController;
use Uzinfocom\Dastyor\Http\Controllers\Builders\RequestBuilderController;
use Uzinfocom\Dastyor\Http\Controllers\Builders\ResourceBuilderController;
use Uzinfocom\Dastyor\Http\Controllers\ControllerBuilderController;
use Uzinfocom\Dastyor\Http\Controllers\MainController;
use Uzinfocom\Dastyor\Http\Controllers\MethodBuilderController;
use Uzinfocom\Dastyor\Http\Controllers\ServiceBuilderController;

Route::get('/', MainController::class)->name('generator.index');

Route::prefix('/advanced')->as('advanced.')->group(function() {
    Route::get('crud', [CrudController::class, 'create'])->name('crud');
    Route::post('crud', [CrudController::class, 'store'])->name('crud.store');
});

Route::prefix('/generate')->group(function() {
    Route::post('models', ModelBuilderController::class)->name('models.store');
    Route::post('services', ServiceBuilderController::class)->name('service.store');
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