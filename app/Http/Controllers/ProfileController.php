<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string|max:20|unique:users,phone,' . Auth::id(),
        ]);

        $user = Auth::user();
        $user->update($request->only('name', 'email', 'phone'));

        return redirect()->route('profile.index')->with('success', 'Perfil actualizado exitosamente.');
    }

    public function updatePassword(Request $request)
    {

        $passwordRules = [
            'required',
            'string',
            \Illuminate\Validation\Rules\Password::min(8)->mixedCase()->numbers()->symbols()->uncompromised(),
        ];

        $messages = [
            'new_password.required' => 'Your password must meet the following requirements:',
            'new_password.min' => 'Your password must meet the following requirements:',
            'new_password.mixed_case' => 'Your password must meet the following requirements:',
            'new_password.numbers' => 'Your password must meet the following requirements:',
            'new_password.symbols' => 'Your password must meet the following requirements:',
            'new_password.uncompromised' => 'Your password must meet the following requirements:',
        ];

        $validated = $request->validate([
            'current_password' => 'required',
            'new_password' => $passwordRules,
            'new_password_confirmation' => ['required', 'string'],
        ], $messages);

        if ($request->new_password !== $request->new_password_confirmation) {
            return back()->withErrors(['new_password_confirmation' => 'Your passwords do not match. Please try again.'])->withInput();
        }

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'La contraseña actual es incorrecta.']);
        }

        $user->update(['password' => Hash::make($request->new_password)]);

        return redirect()->route('profile.index')->with('success', 'Contraseña actualizada exitosamente.');
    }
}
