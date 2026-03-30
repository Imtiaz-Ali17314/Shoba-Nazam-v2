<?php

use Illuminate\Support\Facades\Route;

// Home / root
Route::get('/', function () {
    return view('app');
});

// Catch-all route for SPA (non-API)
Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');