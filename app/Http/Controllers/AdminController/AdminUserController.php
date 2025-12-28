<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

// OTP related
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Mail\UserOtpMail;
use Carbon\Carbon;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::all();

        return view('admin.users', compact('users'));
    }

    // ==============================
    // SEND OTP
    // ==============================
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email'
        ]);

        $otp = rand(100000, 999999);

        DB::table('email_otps')->updateOrInsert(
            ['email' => $request->email],
            [
                'otp'         => $otp,
                'expires_at'  => now()->addMinutes(5),
                'updated_at'  => now(),
                'created_at'  => now(),
            ]
        );

        Mail::to($request->email)->send(new UserOtpMail($otp));

        return response()->json([
            'success'    => true,
            'message'    => 'OTP sent to email',
            'expires_in' => 300 // 5 minutes
        ]);
    }

    // ==============================
    // VERIFY OTP & CREATE USER
    // ==============================
    public function verifyOtpAndCreate(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp'   => 'required|digits:6',
        ]);

        $record = DB::table('email_otps')
            ->where('email', $request->email)
            ->where('otp', $request->otp)
            ->where('expires_at', '>=', now())
            ->first();

        if (!$record) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired OTP'
            ], 422);
        }

        // NID IMAGE
        $nidImageName = null;

        if ($request->hasFile('nid_image')) {
            $nidImageName = $request->file('nid_image')
                ->store('nid_images', 'public');
        }

        $user = User::create([
    'name'       => $request->name,
    'email'      => $request->email,
    'phone'      => $request->phone,
    'dob'        => $request->dob,
    'nid'        => $request->nid,
    'nid_image'  => $nidImageName,
    'address'    => $request->address,
    'occupation' => $request->occupation,
    'income'     => $request->income,
    'role'       => $request->role ?? 'user',
    'status'     => 'active',
    'password'   => bcrypt($request->password),
]);

        DB::table('email_otps')
            ->where('email', $request->email)
            ->delete();

        return response()->json([
            'success' => true,
            'message' => 'User created successfully',
            'user'    => $user
        ]);

    }

    // ==============================
    // UPDATE USER STATUS
    // ==============================
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:inactive,active,blocked,rejected',
        ]);

        $user = User::findOrFail($id);
        $user->status = $request->status;
        $user->save();

        return back()->with('success', 'User status updated successfully.');
    }

    // ==============================
    // DELETE USER
    // ==============================
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'User deleted successfully!');
    }
}
