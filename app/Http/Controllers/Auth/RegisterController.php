<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegister()
    {
        if (session('user_id')) {
            return redirect()->route('home');
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ], [
            'name.required'      => 'Jméno je povinné.',
            'email.required'     => 'E-mail je povinný.',
            'email.unique'       => 'Tento e-mail je již registrován.',
            'password.required'  => 'Heslo je povinné.',
            'password.min'       => 'Heslo musí mít alespoň 8 znaků.',
            'password.confirmed' => 'Hesla se neshodují.',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'user',
        ]);

        LoginController::loginUser($user);

        return redirect()->route('home')->with('success', 'Registrace proběhla úspěšně! Vítejte, ' . $user->name . '.');
    }
}