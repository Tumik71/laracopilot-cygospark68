<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        if (session('admin_logged_in')) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = [
            'admin@elektro-portal.cz' => 'Admin2024!',
            'redaktor@elektro-portal.cz' => 'Redaktor2024!',
        ];

        if (isset($credentials[$request->email]) && $credentials[$request->email] === $request->password) {
            session([
                'admin_logged_in' => true,
                'admin_user' => explode('@', $request->email)[0],
                'admin_email' => $request->email,
                'admin_role' => $request->email === 'admin@elektro-portal.cz' ? 'Správce' : 'Redaktor'
            ]);
            return redirect()->route('admin.dashboard')->with('success', 'Vítejte v administraci!');
        }

        return back()->withErrors(['email' => 'Nesprávný e-mail nebo heslo.'])->withInput();
    }

    public function logout()
    {
        session()->forget(['admin_logged_in', 'admin_user', 'admin_email', 'admin_role']);
        return redirect()->route('admin.login')->with('success', 'Byli jste úspěšně odhlášeni.');
    }
}