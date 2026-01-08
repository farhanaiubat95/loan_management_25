<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\BankAccount;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;


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

    // disburse
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

    // SSL Commerz Payment
    public function sslPay(Loan $loan)
    {

        try {

            if ($loan->status !== 'approved') {
                throw new \Exception('Loan is not approved.');
            }

            $bankAccount = BankAccount::where('status', 'active')->first();
            if (!$bankAccount) {
                throw new \Exception('No active bank account found.');
            }

            if ($bankAccount->current_balance < $loan->amount) {
                throw new \Exception('Insufficient bank balance.');
            }

            // Create PENDING payment (NO deduction yet)
            $payment = Payment::create([
                'loan_id' => $loan->id,
                'user_id' => $loan->user_id,
                'amount' => $loan->amount,
                'payment_method' => 'sslcommerz',
                'transaction_id' => uniqid('SSL-'),
                'type' => 'disbursement',
                'status' => 'pending',
            ]);

            $url = config('sslcommerz.sandbox')
                ? config('sslcommerz.sandbox_url')
                : config('sslcommerz.live_url');

            $response = Http::asForm()->post($url, [
                // STORE INFO
                'store_id'      => config('sslcommerz.store_id'),
                'store_passwd'  => config('sslcommerz.store_password'),

                // TRANSACTION
                'total_amount' => $payment->amount,
                'currency'     => 'BDT',
                'tran_id'      => $payment->transaction_id,

                // CALLBACK URLS
                'success_url'  => route('ssl.success'),
                'fail_url'     => route('ssl.fail'),
                'cancel_url'   => route('ssl.cancel'),

                // CUSTOMER INFO
                'cus_name'     => $loan->user->name,
                'cus_email'    => $loan->user->email,
                'cus_phone'    => $loan->user->phone ?? '01700000000',
                'cus_add1'     => $loan->user->address ?? 'Dhaka',
                'cus_city'     => 'Dhaka',
                'cus_country'  => 'Bangladesh',
                'cus_postcode' => '1207',

                // REQUIRED PRODUCT INFO
                'shipping_method' => 'NO',
                'num_of_item'     => 1,
                'product_name'    => 'Loan Disbursement',
                'product_category'=> 'Loan',
                'product_profile' => 'general',
            ]);


            if (!isset($response['GatewayPageURL'])) {
                throw new \Exception('SSL Gateway URL not returned.');
            }

            return redirect($response['GatewayPageURL']);

        } catch (\Exception $e) {

            return back()->with('error', 'SSL Init Failed: ' . $e->getMessage());
        }
    }


    // SSL Success Callback
   public function sslSuccess(Request $request)
    {
        
        // FAKE / DEMO SUCCESS FLOW
        // SSL sandbox sometimes redirects without POST data
        if (!$request->has('tran_id')) {
            return redirect()
                ->route('admin.payment')
                ->with('success', 'Loan transfer successful (Demo Mode).');
        }

        DB::beginTransaction();

        try {
            $payment = Payment::where('transaction_id', $request->tran_id)
                ->where('status', 'pending')
                ->lockForUpdate()
                ->firstOrFail();

            $loan = Loan::findOrFail($payment->loan_id);
            $bankAccount = BankAccount::where('status', 'active')->firstOrFail();

            // FAKE: assume bank has enough balance
            $bankAccount->decrement('current_balance', $payment->amount);

            $payment->update(['status' => 'success']);
            $loan->update(['status' => 'disbursed']);

            DB::commit();

            return redirect()
                ->route('admin.payment.success', $loan->id)
                ->with('success', 'Loan transfer successful');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->route('admin.payment')
                ->with('error', 'Payment error: ' . $e->getMessage());
        }
    }



    // SSL Fail Callback
    public function sslFail()
    {
        return redirect()->route('admin.payment')
            ->with('error', 'Payment failed');
    }

    // SSL Cancel Callback
    public function sslCancel()
    {
        return redirect()->route('admin.payment')
            ->with('error', 'Payment cancelled');
    }

    // payment success page
    public function paymentSuccess(Loan $loan)
    {
        return view('admin.payment-success', compact('loan'));
    }


    // Validate SSL Payment
    private function validateSslPayment($tranId)
    {
        $url = config('sslcommerz.sandbox')
            ? config('sslcommerz.validation_sandbox_url')
            : config('sslcommerz.validation_live_url');

        $response = Http::get($url, [
            'val_id'        => request('val_id'),
            'store_id'      => config('sslcommerz.store_id'),
            'store_passwd'  => config('sslcommerz.store_password'),
            'format'        => 'json',
        ]);

        if (!$response->successful()) {
            throw new \Exception('SSL validation request failed.');
        }

        $data = $response->json();

        if (
            ($data['status'] ?? '') !== 'VALID' ||
            ($data['tran_id'] ?? '') !== $tranId ||
            ($data['currency'] ?? '') !== 'BDT'
        ) {
            throw new \Exception('SSL validation failed.');
        }

        return $data;
    }

}
