<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\LoanPayment;
use App\Models\User;

class LoanController extends Controller
{
    /**
     * Show all loans (Admin)
     */
    public function index()
    {
        $loans = Loan::with('user')->latest()->get();
        $users = User::where('role', 'user')->get();

        return view('admin.loans', compact('loans', 'users'));
    }

    /**
     * Store new loan & generate EMI schedule
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id'        => 'required|exists:users,id',
            'amount'         => 'required|numeric|min:1',
            'duration'       => 'required|integer|min:1',
            'interest_rate'  => 'required|numeric|min:0',
            'description'    => 'nullable|string',
        ]);

        $P = $request->amount;
        $n = $request->duration;
        $r = ($request->interest_rate / 12) / 100;

        // EMI calculation
        $emi = ($P * $r * pow(1 + $r, $n)) / (pow(1 + $r, $n) - 1);

        // Create loan (IMPORTANT: pending)
        $loan = Loan::create([
            'user_id'       => $request->user_id,
            'amount'        => $P,
            'duration'      => $n,
            'interest_rate' => $request->interest_rate,
            'emi'           => round($emi, 2),
            'description'   => $request->description,
            'status'        => 'pending',
        ]);

        // Create EMI schedule
        for ($i = 1; $i <= $n; $i++) {
            LoanPayment::create([
                'loan_id'            => $loan->id,
                'installment_number' => $i,
                'due_date'           => now()->addMonths($i)->toDateString(),
                'amount'             => round($emi, 2),
                'status'             => 'pending',
            ]);
        }

        return back()->with('success', 'Loan created successfully (Pending approval).');
    }

    /**
     * Update loan basic info
     */
    public function update(Request $request, $id)
    {
        $loan = Loan::findOrFail($id);

    if (in_array($loan->status, ['active', 'completed', 'rejected'])) {
        return back()->with('error', 'This loan cannot be edited.');
    }

    if ($loan->status === 'approved') {
        $loan->update([
            'description' => $request->description,
        ]);
        return back()->with('success', 'Description updated.');
    }

    // pending
    $P = $request->amount;
    $n = $request->duration;
    $r = ($request->interest_rate / 12) / 100;

    $emi = ($P * $r * pow(1 + $r, $n)) / (pow(1 + $r, $n) - 1);

    $loan->update([
        'amount'        => $P,
        'duration'      => $n,
        'interest_rate' => $request->interest_rate,
        'emi'           => round($emi, 2),
        'description'   => $request->description,
    ]);

    return back()->with('success', 'Loan updated successfully.');
    }

    /**
     * Update loan status
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,active,completed',
        ]);

        $loan = Loan::findOrFail($id);

        // Block changes for completed loan
        if ($loan->status === 'completed') {
            return back()->with('error', 'Completed loan cannot be changed.');
        }

        // Business rules
        if ($request->status === 'active' && $loan->status !== 'approved') {
            return back()->with('error', 'Loan must be approved before activation.');
        }

        if ($request->status === 'approved' && $loan->status !== 'pending') {
            return back()->with('error', 'Only pending loans can be approved.');
        }

        $loan->update(['status' => $request->status]);

        return back()->with('success', 'Loan status updated successfully.');
    }

    /**
     * Show EMI schedule
     */
    public function schedule($id)
    {
        $loan = Loan::with(['user', 'paymentsSchedule'])->findOrFail($id);

        // Auto mark overdue EMIs
        foreach ($loan->paymentsSchedule as $installment) {
            if (
                $installment->status === 'pending' &&
                $installment->due_date < now()->toDateString()
            ) {
                $installment->update(['status' => 'overdue']);
            }
        }

        return view('admin.schedule', compact('loan'));
    }

    /**
     * Mark EMI as paid
     */
    public function markInstallmentPaid($id)
    {
        $installment = LoanPayment::findOrFail($id);

        if ($installment->status === 'paid') {
            return back()->with('error', 'This installment is already paid.');
        }

        $installment->update([
            'status'   => 'paid',
            'paid_at' => now(),
        ]);

        $loan = $installment->loan;

        // Auto activate loan on first payment
        if ($loan->status === 'approved') {
            $loan->update(['status' => 'active']);
        }

        // Close loan if all EMIs paid
        if ($loan->paymentsSchedule()->where('status', '!=', 'paid')->count() === 0) {
            $loan->update(['status' => 'completed']);
        }

        return back()->with('success', 'Installment marked as paid.');
    }

    /**
     * Auto mark overdue EMIs (cron job ready)
     */
    public function autoMarkOverdue()
    {
        LoanPayment::where('status', 'pending')
            ->where('due_date', '<', now()->toDateString())
            ->update(['status' => 'overdue']);
    }


    // Delete loan
    public function destroy($id)
{
    $loan = Loan::findOrFail($id);

    // Prevent deleting completed loan
    if ($loan->status === 'completed') {
        return back()->with('error', 'Completed loans cannot be deleted.');
    }

    // Delete EMI schedule first
    $loan->paymentsSchedule()->delete();

    // Delete loan
    $loan->delete();

    return back()->with('success', 'Loan deleted successfully.');
}

}
