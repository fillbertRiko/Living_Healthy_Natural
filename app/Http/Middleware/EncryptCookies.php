<?php

namespace App\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

class EncryptCookies extends Middleware
{
    /**
     * The names of the cookies that should not be encrypted.
     *
     * @var array
     */
    protected $except = [
        'cart_items',
        'cart_total',
        'cart_currency',
        'cart_discount',
        'cart_discount_code',
        'cart_discount_type',
        'cart_discount_amount',
        'cart_discount_expiry',
        'cart_discount_applied',
        'cart_discount_description',
        'cart_discount_code_applied',
        'cart_discount_code_description',
        'cart_discount_code_expiry',
        'cart_discount_code_amount',
        'cart_discount_code_type',
    ];
}
