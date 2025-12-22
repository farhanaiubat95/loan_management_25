<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;

        return match ($role) {
            'admin'   => redirect()->route('admin.dashboard'),
            'manager' => redirect()->route('manager.dashboard'),
            default   => redirect()->route('user.dashboard'),
        };
    }
}
