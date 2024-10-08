<?php

use App\Http\Controllers\tinyController;
use Illuminate\Support\Facades\Route;

Route::get('/',  [tinyController::class, 'index']);

Route::post('/api/v1/short-urls', [tinyController::class, 'short'])->name('shortUrl');