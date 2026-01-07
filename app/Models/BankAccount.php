<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    /**
     * Mass assignable fields
     */
    protected $fillable = [
        'bank_id',
        'account_name',
        'account_number',
        'current_balance',
        'currency',
        'status',       // active | inactive
        'notes',
    ];

    /**
     * Each bank account belongs to one bank
     */
    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }
}
