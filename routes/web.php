<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('guest');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});
