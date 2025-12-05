<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|max:255|unique:users,email,' . $id,
            'phone'       => 'required|string|max:20',
            'dob'         => 'required|date',
            'nid'         => 'required|string|max:50',
            'address'     => 'required|string|max:500',
            'occupation'  => 'required|string|max:255',
            'income'      => 'required|numeric',
            'role'        => 'required|in:user,manager,admin',
            'nid_image'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = User::findOrFail($id);

        if ($request->hasFile('nid_image')) {
            $imageName = time().'_'.$request->file('nid_image')->getClientOriginalName();
            $request->file('nid_image')->storeAs('public/nid_images', $imageName);
            $user->nid_image = $imageName;
        }

        $user->update([
            'name'        => $request->name,
            'email'       => $request->email,
            'phone'       => $request->phone,
            'dob'         => $request->dob,
            'nid'         => $request->nid,
            'address'     => $request->address,
            'occupation'  => $request->occupation,
            'income'      => $request->income,
            'role'        => $request->role,
        ]);

        return redirect()->back()->with('success', 'User updated successfully!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'User deleted successfully!');
    }
}
