<?php

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;

uses(RefreshDatabase::class);

test('forgot password screen can be rendered', function () {
    $response = $this->get(route('password.request'));

    $response->assertOk();
});

test('user can request a password reset link', function () {
    Notification::fake();

    $user = User::factory()->create();

    $response = $this->post(route('password.email'), [
        'email' => $user->email,
    ]);

    $response->assertSessionHas('status');

    Notification::assertSentTo($user, ResetPassword::class);
});

test('reset password screen can be rendered', function () {
    $user = User::factory()->create();
    $token = Password::broker()->createToken($user);

    $response = $this->get(route('password.reset', ['token' => $token, 'email' => $user->email]));

    $response->assertOk();
});

test('user can reset password with valid token', function () {
    $user = User::factory()->create();
    $token = Password::broker()->createToken($user);


    $uniquePassword = 'A1b2C3d4!@#xyz';
    $response = $this->post(route('password.update'), [
        'token' => $token,
        'email' => $user->email,
        'password' => $uniquePassword, // meets all rules and is unique
        'password_confirmation' => $uniquePassword,
    ]);

    $response->assertRedirect(route('login'));
    $response->assertSessionHas('status');

    expect(Hash::check($uniquePassword, $user->fresh()->password))->toBeTrue();
});
