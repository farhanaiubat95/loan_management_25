<?php

namespace App\Http\Controllers\UserController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Loan;
use App\Models\LoanType;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewLoanApplication;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Log;


class UserDashboardController extends Controller
{
    public function dashboard()
    {
        $loanTypes = LoanType::all();
        return view('dashboard.user', compact('loanTypes'));
    }

   public function store(Request $request)
{
    try {
        $request->validate([
            'amount'       => 'required|numeric|min:1',
            'loan_type_id' => 'required|exists:loan_types,id',
            'duration'     => 'required|integer|min:1',
            'description'  => 'nullable|string|max:500',
        ]);

        $loanType = LoanType::findOrFail($request->loan_type_id);

        if ($request->duration < $loanType->min_duration || $request->duration > $loanType->max_duration) {
            return response()->json(['errors' => ['duration' => ["Duration must be between {$loanType->min_duration} and {$loanType->max_duration} months."]]], 422);
        }

        if ($request->amount < $loanType->min_amount || $request->amount > $loanType->max_amount) {
            return response()->json(['errors' => ['amount' => ["Amount must be between {$loanType->min_amount} and {$loanType->max_amount} Tk."]]], 422);
        }

        $interestRate = $loanType->interest_rate;
        $emi = ($request->amount + ($request->amount * $interestRate / 100)) / $request->duration;

        $loan = Loan::create([
            'user_id'       => Auth::id(),
            'loan_type_id'  => $loanType->id,
            'loan_type'     => $loanType->name,
            'amount'        => $request->amount,
            'duration'      => $request->duration,
            'interest_rate' => $interestRate,
            'emi'           => round($emi, 2),
            'description'   => $request->description,
            'status'        => 'pending',
        ]);

        try {
            $adminEmail = config('mail.admin_email');
            Mail::to($adminEmail)->send(new NewLoanApplication($loan));
        } catch (\Exception $e) {
            Log::error("Mail failed: " . $e->getMessage());
        }

        return response()->json(['success' => true]);

    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json(['errors' => $e->errors()], 422);
    } catch (\Exception $e) {
        
        Log::error("Loan apply error: " . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'Something went wrong.'], 500);
    }
}

}


