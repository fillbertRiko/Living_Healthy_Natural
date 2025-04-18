<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        $role = Auth::user()->role; // Assuming 'role' is a field in your users table
        switch ($role) {
            case 'superadmin':
                return redirect('/superadmin');
            case 'admin':
                return redirect('/admin');
            case 'user':
                return redirect('/user');
            default:
                return redirect('/'); // Default fallback
        }
    }
    return view('welcome');
});

// checkRole middleware
Route::get('/superadmin', function () {
    return 'Super Admin Page';
})->middleware('checkRole:superadmin');

Route::get('/admin', function () {
    return 'Admin Page';
})->middleware('checkRole:admin');

Route::get('/user', function () {
    return 'User Page';
})->middleware('checkRole:user');
