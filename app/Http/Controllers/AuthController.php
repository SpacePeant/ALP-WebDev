<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        // Cek di tabel customers (password hash)
        $customer = DB::table('customers')->where('email', $request->email)->first();
        if ($customer && Hash::check($request->password, $customer->password)) {
            Session::put('user_id', $customer->id);
            Session::put('user_name', $customer->name);
            return redirect('/home');
        }

        // Cek di tabel admins (plain password)
        $admin = DB::table('admins')->where('email', $request->email)->first();
        if ($admin && $request->password === $admin->password) {
            Session::put('user_id', $admin->id);
            Session::put('user_name', $admin->name);
            return redirect('/orderadmin');
        }

        return back()->withErrors(['email' => 'Email or password incorrect'])->withInput();
    }
}
