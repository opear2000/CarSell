<?php

namespace Database\Factories;

use App\Models\CarType;
use App\Models\City;
use App\Models\FuelType;
use App\Models\Maker;
use App\Models\Model;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */
class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'maker_id' => Maker::inRandomOrder()->first()->id,
            'model_id' => function(array $attributes) {
                return Model::where('maker_id', $attributes['maker_id'])
                ->inRandomOrder()->first()->id;
            },
            'year' => fake()->year(),
            'price'=> ((int) fake()->randomFloat(nbMaxDecimals:2, min:5, max:100)) * 1000,
            'vin' => strtoupper(Str::random(length: 17)),       
            'mileage' => ((int) fake()->randomFloat(nbMaxDecimals:2, min:5, max:500)) * 1000,
            'car_type_id' => CarType::inRandomOrder()->first()->id,
            'fuel_type_id' => FuelType::inRandomOrder()->first()->id,
            'user_id' => User::inRandomOrder()->first()->id,
            'city_id' => City::inRandomOrder()->first()->id,
            'address' => fake()->address(),
            'phone' => function (array $attributes) {
                return User::find($attributes['user_id'])->phone;
            },
           'description' => fake()->text(maxNbChars:2000),
           'published_at' => fake()->optional(weight: 0.9)->dateTimeBetween(startDate: '-1 month', endDate: 'now')?->format('Y-m-d H:i:s'),
          ];    
    }
}
