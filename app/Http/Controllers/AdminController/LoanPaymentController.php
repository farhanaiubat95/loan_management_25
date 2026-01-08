<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\BankAccount;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

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
        if ($loan->status !== 'approved') {
            return back()->with('error', 'Loan is not approved.');
        }

        // TEMP: using first active bank account
        $bankAccount = BankAccount::where('status', 'active')->first();

        if (!$bankAccount) {
            return back()->with('error', 'No active bank account found.');
        }

        // ATOMIC TRANSACTION
        DB::beginTransaction();

        try {

            // 1 - Check balance
            if ($bankAccount->current_balance < $loan->amount) {
                DB::rollBack();
                return back()->with('error', 'Insufficient bank balance.');
            }

            // 2 - Deduct balance
            $bankAccount->decrement('current_balance', $loan->amount);

            // 3 - Create payment record
            Payment::create([
                'loan_id' => $loan->id,
                'user_id' => $loan->user_id,
                'amount' => $loan->amount,
                'payment_method' => 'bank',
                'transaction_id' => uniqid('DISB-'),
                'type' => 'disbursement',
                'status' => 'success',
                'paid_at' => now(),
            ]);

            // 4 - Update loan status
            $loan->update([
                'status' => 'disbursed'
            ]);

            DB::commit();

            return back()->with('success', 'Loan disbursed successfully.');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Disbursement failed: ' . $e->getMessage());
        }
    }

}
