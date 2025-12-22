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

        // Lock table to avoid duplicate numbers
        $lastNumber = DB::table('users')
            ->lockForUpdate()
            ->where('account_number', 'like', 'LONE%')
            ->max(DB::raw("CAST(SUBSTRING(account_number, 5) AS UNSIGNED)"));

        $nextNumber = $lastNumber ? $lastNumber + 1 : 1;

        $user->account_number = 'LONE' . str_pad($nextNumber, 2, '0', STR_PAD_LEFT);
    });
}
}
