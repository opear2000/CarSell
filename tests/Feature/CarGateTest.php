<?php

use App\Models\Car;
use App\Models\User;
use App\Models\Maker;
use App\Models\Model as CarModel;
use App\Models\CarType;
use App\Models\FuelType;
use App\Models\City;
use App\Models\State;
use Illuminate\Support\Facades\Gate;

use function Pest\Laravel\actingAs;

function createCarWithRelations($user = null) {
    $maker = Maker::factory()->create();
    $carModel = CarModel::factory()->create(['maker_id' => $maker->id]);
    $carType = CarType::factory()->create();
    $fuelType = FuelType::factory()->create();
    $state = State::factory()->create();
    $city = City::factory()->create(['state_id' => $state->id]);
    $user = $user ?: User::factory()->create();
    return Car::factory()->create([
        'maker_id' => $maker->id,
        'model_id' => $carModel->id,
        'car_type_id' => $carType->id,
        'fuel_type_id' => $fuelType->id,
        'city_id' => $city->id,
        'user_id' => $user->id,
    ]);
}

// Test: Only the car owner can edit/update/delete
it('allows only the car owner to edit, update, or delete', function () {
    $owner = User::factory()->create();
    $otherUser = User::factory()->create();
    $car = createCarWithRelations($owner);

    actingAs($owner);
    expect(Gate::allows('update-car', $car))->toBeTrue();

    actingAs($otherUser);
    expect(Gate::denies('update-car', $car))->toBeTrue();
});

// Test: Guests cannot update cars
it('denies guests from updating cars', function () {
    $car = createCarWithRelations();
    expect(Gate::denies('update-car', $car))->toBeTrue();
});
