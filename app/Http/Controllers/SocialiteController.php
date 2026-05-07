<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    /** @var array<int, string> */
    private const ALLOWED_PROVIDERS = ['google', 'facebook'];

    public function redirectToProvider(string $provider): RedirectResponse
    {
        abort_unless(in_array($provider, self::ALLOWED_PROVIDERS, true), 404);

        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback(Request $request, string $provider): RedirectResponse
    {
        abort_unless(in_array($provider, self::ALLOWED_PROVIDERS, true), 404);

        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors(['social_login' => 'Error al autenticar con ' . ucfirst($provider) . '. Por favor, inténtalo de nuevo.']);
        }

        $providerIdField = $provider . '_id';
        $providerId = (string) $socialUser->getId();
        $email = $socialUser->getEmail() ?? $provider . '_' . $providerId . '@noemail.local';
        $name = $socialUser->getName() ?? $socialUser->getNickname() ?? ucfirst($provider) . ' User';

        $user = User::query()->where($providerIdField, $providerId)->first();

        if ($user === null) {
            $user = User::query()->where('email', $email)->first();
        }

        if ($user === null) {
            $user = User::query()->create([
                'name' => $name,
                'email' => $email,
                'password' => Str::password(20),
                'email_verified_at' => now(),
                $providerIdField => $providerId,
            ]);
        } else {
            $updates = [];

            if (blank($user->{$providerIdField})) {
                $updates[$providerIdField] = $providerId;
            }

            if ($user->email_verified_at === null) {
                $updates['email_verified_at'] = now();
            }

            if ($updates !== []) {
                $user->update($updates);
            }
        }

        Auth::login($user, true);
        $request->session()->regenerate();

        return redirect()->intended(route('home'))->with('success', 'Inicio de sesión exitoso con ' . ucfirst($provider) . '!');
    }
}
