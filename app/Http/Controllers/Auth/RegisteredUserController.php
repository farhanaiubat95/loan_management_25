<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Mail\UserOtpMail;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    // SEND OTP
    public function sendOtp(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:8|confirmed'
            ]);

            // Handle file upload FIRST
            $data = $request->except('_token');
            if ($request->hasFile('nid_image')) {
                $path = $request->file('nid_image')->store('public/nid_images');
                $data['nid_image'] = basename($path);
            }

            session(['register_data' => $data]);

            $otp = rand(100000, 999999);

            DB::table('email_otps')->updateOrInsert(
                ['email' => $request->email],
                [
                    'otp' => $otp,
                    'expires_at' => now()->addMinutes(5),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            Mail::to($request->email)->send(new UserOtpMail($otp));

            return response()->json(['success' => true]);

        } catch (\Throwable $e) {
            return response()->json([
                'error' => 'OTP failed',
                'message' => $e->getMessage()
            ], 422);
        }
    }

    // VERIFY OTP
    public function verifyOtp(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'otp' => 'required|digits:6'
            ]);

            $otpRow = DB::table('email_otps')
                ->where('email', $request->email)
                ->where('otp', $request->otp)
                ->where('expires_at', '>=', now())
                ->first();

            if (!$otpRow) {
                return response()->json(['error' => 'Invalid or expired OTP'], 422);
            }

            $data = session('register_data');
            if (!$data) {
                return response()->json(['error' => 'Session expired'], 422);
            }

            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'dob' => $data['dob'],
                'nid' => $data['nid'],
                'nid_image' => $data['nid_image'] ?? null,
                'address' => $data['address'],
                'occupation' => $data['occupation'],
                'income' => $data['income'],
                'role' => 'user',
                'status' => 'inactive',
                'password' => bcrypt($data['password']),
            ]);

            Auth::login($user);

            DB::table('email_otps')->where('email', $request->email)->delete();
            session()->forget('register_data');

            return response()->json(['success' => true]);

        } catch (\Throwable $e) {
            return response()->json([
                'error' => 'Verification failed',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
