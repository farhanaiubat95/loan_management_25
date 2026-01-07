<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\BankAccount;
use Illuminate\Http\Request;

class BankController extends Controller
{
    public function index()
    {
        $banks = Bank::with('accounts')->get();
        return view('admin.banks.index', compact('banks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bank_name' => 'required|string|max:255',
            'account_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255|unique:bank_accounts',
            'current_balance' => 'required|numeric|min:0',
        ]);

        $bank = Bank::firstOrCreate(
            ['name' => $request->bank_name],
            ['status' => 'active']
        );

        BankAccount::create([
            'bank_id' => $bank->id,
            'account_name' => $request->account_name,
            'account_number' => $request->account_number,
            'current_balance' => $request->current_balance,
            'status' => 'active',
        ]);

        return back()->with('success', 'Bank account added successfully');
    }

    public function toggleAccount(BankAccount $account)
    {
        $account->update([
            'status' => $account->status === 'active' ? 'inactive' : 'active'
        ]);

        return back();
    }
}
