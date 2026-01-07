<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
    'loan_id',
    'loan_payment_id',
    'user_id',
    'amount',
    'payment_method',
    'transaction_id',
    'type',         
    'status',       
    'notes',
    'paid_at',
    ];


    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class);
    }

    public function installment()
    {
        return $this->belongsTo(LoanPayment::class, 'loan_payment_id');
    }
}
