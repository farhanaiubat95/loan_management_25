<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Loan;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::where('role', 'user')->count();
        $totalLoans = Loan::whereIn('status', ['active', 'completed'])->count();
        $pendingLoans = Loan::where('status', 'pending')->count();

        $recentLoans = Loan::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.admin', compact(
            'totalUsers',
            'totalLoans',
            'pendingLoans',
            'recentLoans'
        ));
    }
}
