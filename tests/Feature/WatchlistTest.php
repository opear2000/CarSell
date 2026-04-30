<?php

use App\Models\Car;
use App\Models\CarType;
use App\Models\City;
use App\Models\FuelType;
use App\Models\Maker;
use App\Models\Model;
use App\Models\State;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function createPublishedCar(array $overrides = []): Car
{
    $owner = User::factory()->create();
    $maker = Maker::factory()->create();
    $model = Model::factory()->create(['maker_id' => $maker->id]);
    $state = State::factory()->create();
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

test('authenticated user can add a car to watchlist', function () {
    $user = User::factory()->create();
    $car = createPublishedCar();

    $this->actingAs($user)
        ->post(route('car.watchlist.store', $car))
        ->assertRedirect();

    $this->assertDatabaseHas('favorite_cars', [
        'user_id' => $user->id,
        'car_id' => $car->id,
    ]);
});

test('authenticated user can remove a car from watchlist', function () {
    $user = User::factory()->create();
    $car = createPublishedCar();

    $user->favoriteCars()->attach($car->id);

    $this->actingAs($user)
        ->delete(route('car.watchlist.destroy', $car))
        ->assertRedirect();

    $this->assertDatabaseMissing('favorite_cars', [
        'user_id' => $user->id,
        'car_id' => $car->id,
    ]);
});

test('guest cannot add a car to watchlist', function () {
    $car = createPublishedCar();

    $this->post(route('car.watchlist.store', $car))
    ->assertRedirect(route('home'));
});
