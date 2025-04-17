<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//checkRole middleware
Route::get('/superadmin', function () {
    return 'Super Admin Page';
})->middleware('checkRole:superadmin');
Route::get('/admin', function () {
    return 'Admin Page';
})->middleware('checkRole:admin');
Route::get('/user', function () {
    return 'User Page';
})->middleware('checkRole:user');
