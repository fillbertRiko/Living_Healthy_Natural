<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VeryfyCsrfToken extends Middleware
{
    protected $except = [
        'api/*', // Exclude all API routes
        'webhook/*', // Exclude all webhook routes
        'cart/*', // Exclude all cart-related routes
        'cart/checkout/*', // Exclude all checkout-related routes
        'cart/checkout/redirect/*', // Exclude all redirect-related routes
    ];
}
