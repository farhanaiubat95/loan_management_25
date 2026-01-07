<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Models\Loan;

class LoanPaymentController extends Controller
{

    public function index()
    {
        $loans = Loan::with('user')
            ->where('status', 'approved')
            ->get();

        return view('admin.payment', compact('loans'));
    }
    public function show(Loan $loan)
    {
        // Optional safety check
        if ($loan->status !== 'approved') {
            return back()->with('error', 'Only approved loans can be paid.');
        }

        return view('admin.payment', compact('loan'));
    }

    public function disburse(Loan $loan)
    {
        // TEMP: just testing flow
        // SSLCommerz will be added later

        return back()->with('success', 'Disbursement flow started for Loan ID: ' . $loan->id);
    }
}
