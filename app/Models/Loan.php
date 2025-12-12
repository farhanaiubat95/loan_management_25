<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $fillable = [
        'user_id',
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

    // Actual payment transactions
    public function transactions()
    {
        return $this->hasMany(Payment::class);
    }
}
