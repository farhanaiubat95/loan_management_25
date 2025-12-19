<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\LoanPayment;
use App\Models\User;

class LoanController extends Controller
{
 public function index()
{
    $loans = Loan::with('user')->latest()->get();
    $users = User::where('role', 'user')->get(); // only normal users

    return view('admin.loans', compact('loans', 'users'));
}


public function store(Request $request)
{
    $request->validate([
        'user_id' => 'required',
        'amount' => 'required|numeric',
        'duration' => 'required|integer',
        'interest_rate' => 'required|numeric',
    ]);

    // EMI Calculation
    $P = $request->amount;
    $r = ($request->interest_rate / 12) / 100;
    $n = $request->duration;

    $emi = ($P * $r * pow(1 + $r, $n)) / (pow(1 + $r, $n) - 1);

    // Create Loan
    $loan = Loan::create([
        'user_id' => $request->user_id,
        'amount' => $P,
        'duration' => $n,
        'interest_rate' => $request->interest_rate,
        'emi' => round($emi, 2),
        'description' => $request->description,
        'status' => 'active',
    ]);

    // Create EMI schedule
    for ($i = 1; $i <= $n; $i++) {
        LoanPayment::create([
            'loan_id' => $loan->id,
            'installment_number' => $i,
            'due_date' => now()->addMonths($i)->format('Y-m-d'),
            'amount' => round($emi, 2),
            'principal' => null, // optional if you want breakdown later
            'interest' => null,
            'status' => 'pending',
        ]);
    }

    return back()->with('success', 'Loan & EMI schedule created successfully.');
}


// -------------------------------
// UPDATE LOAN
// -------------------------------
public function update(Request $request, $id)
{
    $loan = Loan::findOrFail($id);

    $loan->update([
        'amount' => $request->amount,
        'duration' => $request->duration,
        'interest_rate' => $request->interest_rate,
        'description' => $request->description,
    ]);

    return back()->with('success', 'Loan updated successfully!');
}

public function updateStatus(Request $request, $id)
{
    $loan = Loan::findOrFail($id);
    $loan->status = $request->status;
    $loan->save();

    return back()->with('success', 'Loan status updated successfully.');
}

// Payment schedule()
public function schedule($id)
{
    $loan = Loan::with('user', 'paymentsSchedule')->findOrFail($id);

    // Mark overdue installments
    foreach ($loan->paymentsSchedule as $installment) {
        if ($installment->status === 'pending' && $installment->due_date < now()->toDateString()) {
            $installment->status = 'overdue';
        }
    }

    return view('admin.schedule', compact('loan'));
}

// Mark installment as paid
public function markInstallmentPaid($id)
{
    $installment = LoanInstallment::findOrFail($id);

    // Mark as paid
    $installment->status = 'paid';
    $installment->paid_at = now();
    $installment->save();

    // If all installments paid — close the loan
    $loan = $installment->loan;
    if ($loan->installments()->where('status', 'pending')->count() === 0) {
        $loan->status = 'completed';
        $loan->save();
    }

    return back()->with('success', 'Installment marked as paid.');
}

// Auto mark installments as overdue
public function autoMarkOverdue()
{
    LoanInstallment::where('status', 'pending')
        ->where('due_date', '<', now()->toDateString())
        ->update(['status' => 'overdue']);
}



}
