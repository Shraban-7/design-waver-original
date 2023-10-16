<?php

namespace App\Http\Middleware;


use App\Models\Order;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{

    // Order $order;
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */

    
    protected $except = [
        'success','fail'
    ];
}
