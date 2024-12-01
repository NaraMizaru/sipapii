<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        $user = User::where('username', $request->username)->first();

        if ($user) {
            if ($user->role == 'admin') {
                if (Auth::attempt($request->only('username', 'password'), $request->has('remember'))) {
                    return redirect()->route('admin.dashboard');
                } else {
                    return redirect()->back()->with('error', 'Username atau password salah');
                }
            } else {
                if ($user->password == $request->password) {
                    Auth::login($user, $request->has('remember'));
                    if ($user->role == 'gurus') {
                    } else {
                        return redirect()->route('siswa.dashboard');
                    }
                } else {
                    return redirect()->back()->with('error', 'Username atau password salah');
                }
            }
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
