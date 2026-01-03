<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanType extends Model
{
    protected $fillable = [
        'name',
        'interest_rate',
        'min_amount',
        'max_amount',
        'min_duration',
        'max_duration',
        'benefits',
        'process',
        'description',
        'is_active',
    ];

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
}
