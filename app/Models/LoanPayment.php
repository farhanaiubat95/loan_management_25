<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanPayment extends Model
{
    protected $fillable = [
        'loan_id',
        'installment_number',
        'due_date',
        'amount',
        'principal',
        'interest',
        'late_fee',
        'status',
        'paid_amount',
        'paid_at',
    ];

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    public function transaction()
    {
        return $this->hasOne(Payment::class, 'loan_payment_id');
    }
}
