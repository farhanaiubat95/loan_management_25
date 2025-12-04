<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;

        return match ($role) {
            'admin'   => view('dashboard.admin'),
            'manager' => view('dashboard.manager'),
            default   => view('dashboard.user'),
        };
    }
}
