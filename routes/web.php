<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/',
    function () {
        if (!Auth::check()) {
            return view('welcome');
        } else {
            $redirectRoutes = [
                'superadmin' => '/superadmin',
                'admin' => '/admin',
                'user' => '/user',
            ];

            return redirect($redirectRoutes[Auth::user()->role] ?? '/');
        }

    });
