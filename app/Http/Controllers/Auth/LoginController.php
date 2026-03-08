<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLogin()
    {
        if (session('user_id')) {
            return redirect()->route('home');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors(['email' => 'Nesprávný e-mail nebo heslo.'])->withInput();
        }

        if ($user->banned_at) {
            return back()->withErrors(['email' => 'Váš účet byl zablokován. Kontaktujte podporu.']);
        }

        // 2FA aktivní
        if ($user->two_factor_enabled) {
            session(['2fa_user_id' => $user->id]);
            // Vygeneruj a ulož kód
            $code = rand(100000, 999999);
            $user->update([
                'two_factor_code'       => $code,
                'two_factor_expires_at' => now()->addMinutes(10),
            ]);
            // V produkci odesílejte kód e-mailem nebo SMS
            // Mail::to($user->email)->send(new TwoFactorMail($code));
            // Pro vývoj kód zobrazíme v session flash
            session()->flash('dev_2fa_code', $code);
            return redirect()->route('2fa.show');
        }

        $this->loginUser($user);
        return redirect()->intended(route('home'));
    }

    public function logout()
    {
        session()->forget(['user_id', 'user_name', 'user_email', 'user_role']);
        return redirect()->route('home');
    }

    public static function loginUser(User $user)
    {
        session([
            'user_id'    => $user->id,
            'user_name'  => $user->name,
            'user_email' => $user->email,
            'user_role'  => $user->role,
        ]);
        $user->update(['last_login_at' => now()]);
    }
}