<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class TwoFactorController extends Controller
{
    public function show()
    {
        if (!session('2fa_user_id') && !session('user_id')) {
            return redirect()->route('login');
        }
        return view('auth.two-factor');
    }

    public function verify(Request $request)
    {
        $request->validate(['code' => 'required|digits:6']);

        $userId = session('2fa_user_id');
        $user   = User::findOrFail($userId);

        if ($user->two_factor_code !== (int)$request->code) {
            return back()->withErrors(['code' => 'Nesprávný ověřovací kód.']);
        }

        if ($user->two_factor_expires_at < now()) {
            return back()->withErrors(['code' => 'Platnost kódu vypršela. Přihlaste se znovu.']);
        }

        $user->update([
            'two_factor_code'       => null,
            'two_factor_expires_at' => null,
        ]);

        session()->forget('2fa_user_id');
        LoginController::loginUser($user);

        return redirect()->route('home');
    }

    public function setup()
    {
        if (!session('user_id')) {
            return redirect()->route('login');
        }
        $user = User::findOrFail(session('user_id'));
        return view('auth.2fa-setup', compact('user'));
    }

    public function activate(Request $request)
    {
        if (!session('user_id')) {
            return redirect()->route('login');
        }
        $user = User::findOrFail(session('user_id'));
        $user->update(['two_factor_enabled' => true]);
        return back()->with('success', 'Dvoufaktorové ověření bylo aktivováno.');
    }

    public function deactivate(Request $request)
    {
        if (!session('user_id')) {
            return redirect()->route('login');
        }
        $user = User::findOrFail(session('user_id'));
        $user->update(['two_factor_enabled' => false, 'two_factor_code' => null]);
        return back()->with('success', 'Dvoufaktorové ověření bylo deaktivováno.');
    }
}