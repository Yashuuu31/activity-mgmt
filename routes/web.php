<?php

use App\Http\Controllers\UserActivityController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [UserController::class, 'index']);
Route::post('generate-activity', [UserActivityController::class, 'generateActivity'])->name('generate-activity');
