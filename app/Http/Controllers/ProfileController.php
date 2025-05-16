<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
public function show(Request $request)
{
    $userId = $request->session()->get('user_id', $request->query('user_id', 1)); // default ke 1
    $user = \App\Models\Customer::find($userId);

    if (!$user) {
        return response("User not found", 404);
    }

    return view('profile', compact('user'));
}
public function update(Request $request)
{
    $userId = $request->session()->get('user_id', $request->query('user_id', 1));
    $user = \App\Models\Customer::find($userId);

    if (!$user) {
        return response("User not found", 404);
    }

    if ($request->field === 'password') {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        if (!Hash::check($request->old_password, $user->password)) {
            return response("Old password is incorrect.", 400);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();
        return response("Password updated successfully.");
    }

    $field = $request->field;
    $value = $request->value;

    if (!in_array($field, ['name', 'phone_number', 'address'])) {
        return response("Invalid field", 400);
    }

    $user->$field = $value;
    $user->save();

    return response("Profile updated successfully.");
}
}