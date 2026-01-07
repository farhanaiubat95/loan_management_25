<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    /**
     * Mass assignable fields
     */
    protected $fillable = [
        'name',
        'status',   // active | inactive
        'notes',
    ];

    /**
     * A bank can have multiple accounts
     * (We will create BankAccount model next)
     */
    public function accounts()
    {
        return $this->hasMany(BankAccount::class);
    }
}
