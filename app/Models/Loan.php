<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $fillable = [
        'user_id',
        'loan_type_id',
        'loan_type',
        'amount',
        'duration',
        'interest_rate',
        'emi',
        'status',
        'description',
    ];

    // A loan belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // A loan has many EMI installments
    public function paymentsSchedule()
    {
        return $this->hasMany(LoanPayment::class);
    }

    public function loanType()
{
    return $this->belongsTo(LoanType::class);
}

    // Actual payment transactions
    public function transactions()
    {
        return $this->hasMany(Payment::class);
    }
}
