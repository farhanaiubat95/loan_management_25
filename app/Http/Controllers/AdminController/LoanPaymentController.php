<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\BankAccount;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Raziul\Sslcommerz\SslcommerzClient;


class LoanPaymentController extends Controller
{

    // show all approved loans for payment
    public function index()
    {
        $loans = Loan::with('user')
            ->where('status', 'approved')
            ->get();

        return view('admin.payment', compact('loans'));
    }

    // show payment page
    public function show(Loan $loan)
    {
        // Optional safety check
        if ($loan->status !== 'approved') {
            return back()->with('error', 'Only approved loans can be paid.');
        }

        return view('admin.payment', compact('loan'));
    }


public function disburse(Loan $loan, SslcommerzClient $ssl)
{
    if ($loan->status !== 'approved') {
        return back()->with('error', 'Loan not approved.');
    }

    /** Get active bank account */
    $bankAccount = BankAccount::where('status', 'active')->first();

    if (!$bankAccount) {
        return back()->with('error', 'No active bank account found.');
    }

    if ($bankAccount->current_balance < $loan->amount) {
        return back()->with('error', 'Insufficient bank balance.');
    }

    $tranId = uniqid('LOAN-');

    /**  ATOMIC TRANSACTION */
    DB::transaction(function () use ($loan, $bankAccount, $tranId) {

        /** Create payment */
        $payment = Payment::create([
            'loan_id'         => $loan->id,
            'user_id'         => $loan->user_id,
            'amount'          => $loan->amount,
            'payment_method' => 'sslcommerz',
            'transaction_id' => $tranId,
            'type'            => 'disbursement',
            'status'          => 'success',
            'paid_at'         => now(),
        ]);

        /** OPTIONAL: link payment to bank account */
        $payment->update([
            'bank_account_id' => $bankAccount->id,
        ]);

        /** UPDATE BANK BALANCE */
        $bankAccount->update([
            'current_balance' => $bankAccount->current_balance - $loan->amount,
        ]);

        /**  UPDATE LOAN STATUS */
        $loan->update([
            'status' => 'disbursed',
        ]);
    });

    /** SSL only for UI / sandbox */
    $response = $ssl->makePayment([
        'total_amount'     => $loan->amount,
        'tran_id'          => $tranId,

        'cus_name'         => $loan->user->name,
        'cus_email'        => $loan->user->email,
        'cus_phone'        => '01700000000',
        'cus_add1'         => 'Dhaka',
        'cus_city'         => 'Dhaka',
        'cus_country'      => 'Bangladesh',

        'shipping_method'  => 'NO',
        'product_name'     => 'Loan Disbursement',
        'product_category' => 'Financial Service',
        'product_profile'  => 'general',

        'success_url' => route('sslc.success'),
        'fail_url'    => route('sslc.failure'),
        'cancel_url'  => route('sslc.cancel'),
    ]);

    return redirect()->away($response->toArray()['GatewayPageURL']);
}


public function sslSuccess(Request $request)
{
    Log::info('SSL SUCCESS HIT', $request->all());

    return redirect()->route('admin.payment')
        ->with('success', 'Payment completed successfully.');
}


public function sslFail(Request $request)
{
    return redirect()
        ->route('admin.payment')
        ->with('error', 'Payment failed.');
}

public function sslCancel(Request $request)
{
    return redirect()
        ->route('admin.payment')
        ->with('error', 'Payment cancelled.');
}



    // payment success page
    public function paymentSuccess()
    {
        return view('admin.payment-success');
    }



}
