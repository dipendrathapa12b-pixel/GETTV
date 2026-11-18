<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SportsController;

Route::get('/', [SportsController::class, 'index'])
    ->name('sports.home');
Route::get('/watch/{id}', [SportsController::class, 'watch'])
    ->whereNumber('id')
    ->name('sports.watch');
