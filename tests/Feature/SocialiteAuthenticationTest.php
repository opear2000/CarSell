<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Socialite\Facades\Socialite;

uses(RefreshDatabase::class);

it('redirects to google provider', function () {
    $provider = \Mockery::mock();
    $provider->shouldReceive('redirect')->once()->andReturn(redirect('https://accounts.google.com/o/oauth2/auth'));

    Socialite::shouldReceive('driver')->once()->with('google')->andReturn($provider);

    $this->get(route('socialite.redirect', 'google'))
        ->assertRedirect('https://accounts.google.com/o/oauth2/auth');
});

it('creates and authenticates user from google callback', function () {
    $socialUser = \Mockery::mock();
    $socialUser->shouldReceive('getId')->andReturn('google-123');
    $socialUser->shouldReceive('getEmail')->andReturn('social@example.com');
    $socialUser->shouldReceive('getName')->andReturn('Social User');
    $socialUser->shouldReceive('getNickname')->andReturnNull();

    $provider = \Mockery::mock();
    $provider->shouldReceive('user')->once()->andReturn($socialUser);

    Socialite::shouldReceive('driver')->once()->with('google')->andReturn($provider);

    $this->get(route('socialite.callback', 'google'))
        ->assertRedirect(route('home'));

    $this->assertAuthenticated();

    $this->assertDatabaseHas('users', [
        'email' => 'social@example.com',
        'google_id' => 'google-123',
    ]);

    expect(User::query()->where('email', 'social@example.com')->first()?->email_verified_at)
        ->not->toBeNull();
});

it('links provider id to existing account by email', function () {
    $user = User::factory()->create([
        'email' => 'existing@example.com',
        'google_id' => null,
    ]);

    $socialUser = \Mockery::mock();
    $socialUser->shouldReceive('getId')->andReturn('google-999');
    $socialUser->shouldReceive('getEmail')->andReturn('existing@example.com');
    $socialUser->shouldReceive('getName')->andReturn('Existing User');
    $socialUser->shouldReceive('getNickname')->andReturnNull();

    $provider = \Mockery::mock();
    $provider->shouldReceive('user')->once()->andReturn($socialUser);

    Socialite::shouldReceive('driver')->once()->with('google')->andReturn($provider);

    $this->get(route('socialite.callback', 'google'))
        ->assertRedirect(route('home'));

    $updatedUser = $user->fresh();

    expect($updatedUser->google_id)->toBe('google-999')
        ->and($updatedUser->email_verified_at)->not->toBeNull();
});

it('redirects back to login when facebook callback fails', function () {
    $provider = \Mockery::mock();
    $provider->shouldReceive('user')->once()->andThrow(new Exception('OAuth failed'));

    Socialite::shouldReceive('driver')->once()->with('facebook')->andReturn($provider);

    $this->get(route('socialite.callback', 'facebook'))
        ->assertRedirect(route('login'))
        ->assertSessionHasErrors(['social_login']);
});
