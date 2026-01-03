<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
    'account_number',
    'name',
    'email',
    'phone',
    'dob',
    'nid',
    'nid_image',
    'address',
    'occupation',
    'income',
    'role', 
    'status',
    'password',
];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    

protected static function booted()
{
    static::creating(function ($user) {
        DB::transaction(function () use ($user) {
            $year = date('Y'); // current year

            // Get the max account number for this year
            $lastNumber = DB::table('users')
                ->where('account_number', 'like', $year . '%')
                ->lockForUpdate()
                ->max(DB::raw("CAST(SUBSTRING(account_number, 5) AS UNSIGNED)"));

            // Start from 10001 if no previous account for this year
            $nextNumber = $lastNumber ? $lastNumber + 1 : 10001;

            // Combine year + padded number
            $user->account_number = $year . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
        });
    });
}



public function loans()
    {
        return $this->hasMany(Loan::class);
    }
}
