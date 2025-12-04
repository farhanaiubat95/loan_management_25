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

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'email'       => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'phone'       => ['required', 'string', 'max:20'],
            'dob'         => ['required', 'date'],
            'nid'         => ['required', 'string', 'max:50'],
            'nid_image'   => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'address'     => ['required', 'string', 'max:500'],
            'occupation'  => ['required', 'string', 'max:255'],
            'income'      => ['required', 'numeric'],
            'password'    => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // ---------------------------
        // Upload NID Image
        // ---------------------------

        $nidImageName = null;

        if ($request->hasFile('nid_image')) {
            $nidImage = $request->file('nid_image');
            $nidImageName = time() . '_' . $nidImage->getClientOriginalName();

            // Store inside storage/app/public/nid_images
            $nidImage->storeAs('public/nid_images', $nidImageName);
        }

        // ---------------------------
        // Create User
        // ---------------------------

        $user = User::create([
            'name'        => $request->name,
            'email'       => $request->email,
            'phone'       => $request->phone,
            'dob'         => $request->dob,
            'nid'         => $request->nid,
            'nid_image'   => $nidImageName,
            'address'     => $request->address,
            'occupation'  => $request->occupation,
            'income'      => $request->income,
            'role'        => 'user',
            'password'    => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
