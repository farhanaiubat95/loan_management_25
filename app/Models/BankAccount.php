<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    /**
     * Mass assignable fields
     */
    protected $fillable = [
        'bank_id',          // which bank this account belongs to
        'account_name',     // e.g. "Loan Disbursement Account"
        'account_number',   // bank account number
        'current_balance',  // available balance
        'currency',         // BDT, USD etc
        'status',           // active | inactive
        'notes',
    ];

    /**
     * Each bank account belongs to ONE bank
     */
    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

     /**
     * Payments made from this bank account
     * (we will link this later)
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
