<?php

use App\Models\Car;
use App\Models\CarType;
use App\Models\City;
use App\Models\FuelType;
use App\Models\Maker;
use App\Models\Model;
use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;

uses(RefreshDatabase::class);

function createPublishedCarForVerificationTests(array $overrides = []): Car
{
    $owner = User::factory()->create();
    $maker = Maker::factory()->create();
    $model = Model::factory()->create(['maker_id' => $maker->id]);
    $state = \App\Models\State::factory()->create();
    $city = City::factory()->create(['state_id' => $state->id]);
    $carType = CarType::factory()->create();
    $fuelType = FuelType::factory()->create();

    return Car::factory()->create(array_merge([
        'user_id' => $owner->id,
        'maker_id' => $maker->id,
        'model_id' => $model->id,
        'city_id' => $city->id,
        'car_type_id' => $carType->id,
        'fuel_type_id' => $fuelType->id,
        'published_at' => now()->subDay(),
    ], $overrides));
}

test('unverified user is redirected to verification notice for verified routes', function () {
    $user = User::factory()->unverified()->create();

    $this->actingAs($user)
    ->get('/about')
        ->assertRedirect(route('verification.notice'));
});

test('unverified user is redirected to verification notice from home', function () {
    $user = User::factory()->unverified()->create();

    $this->actingAs($user)
        ->get(route('home'))
        ->assertRedirect(route('verification.notice'));
});

test('unverified user can still access car details page', function () {
    $user = User::factory()->unverified()->create();
    $car = createPublishedCarForVerificationTests();

    $this->actingAs($user)
        ->get(route('car.show', $car))
        ->assertOk();
});

test('unverified user can request another verification email', function () {
    Notification::fake();

    $user = User::factory()->unverified()->create();

    $this->actingAs($user)
        ->post(route('verification.send'))
        ->assertRedirect();

    Notification::assertSentTo($user, VerifyEmail::class);
});

test('email can be verified with valid signed link', function () {
    $user = User::factory()->unverified()->create();

    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(30),
        [
            'id' => $user->id,
            'hash' => sha1($user->email),
        ]
    );

    $this->actingAs($user)
        ->get($verificationUrl)
        ->assertRedirect(route('home'));

    expect($user->fresh()->hasVerifiedEmail())->toBeTrue();
});
