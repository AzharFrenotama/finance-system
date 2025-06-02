<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('/layouts/app');
});
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/budget', function () {
    return view('profile');});

Route::get('/transaction', function () {
    return view('transaction');});

Route::get('/reports', function () {
    return view('reports');});