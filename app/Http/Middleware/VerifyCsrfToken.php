<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyCsrfToken 
{
    protected $except = [
    'admin/ssl/success',
    'admin/ssl/fail',
    'admin/ssl/cancel',
    ];

}

