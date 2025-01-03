<?php

use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return 'login error';
})->name('login');

// 报名页面
Route::fallback(function () {
    return view('welcome');
});