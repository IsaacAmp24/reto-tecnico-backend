<?php

use App\Http\Controllers\DivisionController;
use Illuminate\Support\Facades\Route;

Route::get('divisions/filter-options', [DivisionController::class, 'filterOptions']);
Route::get('divisions/{division}/subdivisions', [DivisionController::class, 'subdivisions']);
Route::apiResource('divisions', DivisionController::class);