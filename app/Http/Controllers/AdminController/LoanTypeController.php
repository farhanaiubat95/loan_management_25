<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Models\LoanType;
use Illuminate\Http\Request;

class LoanTypeController extends Controller
{
    public function index()
    {
        $loanTypes = LoanType::all();
        return view('admin.loan_types.index', compact('loanTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'interest_rate' => 'required|numeric',
            'min_amount' => 'required|integer',
            'max_amount' => 'required|integer',
            'min_duration' => 'required|integer',
            'max_duration' => 'required|integer',
            'benefits' => 'nullable|string',
            'process' => 'nullable|string',
            'description' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);

        LoanType::create(array_merge(
        $request->only([
                'name',
                'interest_rate',
                'min_amount',
                'max_amount',
                'min_duration',
                'max_duration',
                'benefits',
                'process',
                'description',
            ]),
            ['is_active' => 1]
        ));


        return back()->with('success','Loan Type created successfull');
    }

    public function toggleStatus($id)
{
    $loanType = LoanType::findOrFail($id);
    $loanType->is_active = !$loanType->is_active;
    $loanType->save();

    return back()->with('success', 'Loan status updated successfully.');
}


    public function update(Request $request, $id)
    {
        $loanType = LoanType::findOrFail($id);
        $loanType->update($request->all());

        return back()->with('success','Loan Type updated');
    }

    public function destroy($id)
    {
        LoanType::findOrFail($id)->delete();
        return back()->with('success','Loan Type deleted');
    }
}
