<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Loan;
use App\Models\Payment;
use App\Models\BankAccount;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\LoanStatusApprovedMail;
use App\Mail\LoanStatusRejectedMail;
use Illuminate\Support\Facades\Log;

class AdminDashboardController extends Controller
{
    public function index()
{
    $totalUsers = User::where('role', 'user')->count();

    $totalLoans = Loan::whereIn('status', ['active', 'completed'])->count();

    $pendingLoans = Loan::where('status', 'pending')->count();

    $totalBalance = BankAccount::sum('current_balance');

    $totalBankAccounts = BankAccount::count();

    $totalTransactions = Payment::count();

    $recentLoans = Loan::with('user')
        ->latest()
        ->take(5)
        ->get();

    return view('dashboard.admin', compact(
        'totalUsers',
        'totalLoans',
        'pendingLoans',
        'totalBalance',
        'totalBankAccounts',
        'totalTransactions',
        'recentLoans'
    ));
}

    

public function updateStatus(Request $request, Loan $loan)
{
    $request->validate([
        'status' => 'required|in:approved,rejected,active,completed',
        'reject_reason' => 'nullable|string|max:500',
    ]);

    try {
        $loan->status = $request->status;
        $loan->save();

        // Check user email
        if (!$loan->user || !$loan->user->email) {
            Log::error("Loan {$loan->id}: User email missing");
            return back()->with('error', 'User email not found. Mail not sent.');
        }

        // Send mail
        if ($request->status === 'approved') {
            Mail::to($loan->user->email)
                ->send(new LoanStatusApprovedMail($loan));
        }

        if ($request->status === 'rejected') {
            Mail::to($loan->user->email)
                ->send(new LoanStatusRejectedMail(
                    $loan,
                    $request->reject_reason
                ));
        }

        return back()->with('success', 'Loan status updated & email sent successfully.');

    } catch (\Throwable $e) {

        Log::error('Loan status update mail failed', [
            'loan_id' => $loan->id,
            'status' => $request->status,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);

        return back()->with(
            'error',
            'Loan updated but email failed. Check logs.'
        );
    }
}

}
