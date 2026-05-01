<?php

namespace App\Http\Controllers;
use App\Models\Car;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $maker = $request->integer('maker_id');
        $model = $request->integer('model_id');
        $carType = $request->integer('car_type_id');
        $fuelType = $request->integer('fuel_type_id');
        $state = $request->integer('state_id');
        $city = $request->integer('city_id');
        $yearFrom = $request->integer('year_from');
        $yearTo = $request->integer('year_to');
        $priceFrom = $request->integer('price_from');
        $priceTo = $request->integer('price_to');
        $mileage = $request->integer('mileage');

        $hasFilters = $maker || $model || $carType || $fuelType || $state || $city || $yearFrom || $yearTo || $priceFrom || $priceTo || $mileage;

        if (! $hasFilters) {
            // Use cache for default home page (no filters)
            $cars = cache()->remember('home_cars', 60, function () {
                return Car::where('published_at', '<', now())
                    ->with(['primaryImage', 'city', 'carType', 'fuelType', 'maker', 'model'])
                    ->orderBy('published_at','desc')
                    ->limit(30)
                    ->get();
            });
        } else {
            // Apply filters if any search parameter is present
            $query = Car::where('published_at', '<', now())
                ->with(['primaryImage', 'city', 'carType', 'fuelType', 'maker', 'model'])
                ->orderBy('published_at', 'desc');

            if ($maker) {
                $query->where('maker_id', $maker);
            }
            if ($model) {
                $query->where('model_id', $model);
            }
            if ($carType) {
                $query->where('car_type_id', $carType);
            }
            if ($fuelType) {
                $query->where('fuel_type_id', $fuelType);
            }
            if ($state) {
                $query->whereHas('city', function ($q) use ($state) {
                    $q->where('state_id', $state);
                });
            }
            if ($city) {
                $query->where('city_id', $city);
            }
            if ($yearFrom) {
                $query->where('year', '>=', $yearFrom);
            }
            if ($yearTo) {
                $query->where('year', '<=', $yearTo);
            }
            if ($priceFrom) {
                $query->where('price', '>=', $priceFrom);
            }
            if ($priceTo) {
                $query->where('price', '<=', $priceTo);
            }
            if ($mileage) {
                $query->where('mileage', '<=', $mileage);
            }

            $cars = $query->limit(30)->get();
        }

        $watchlistCarIds = [];
        if ($request->user()) {
            $watchlistCarIds = $request->user()->favoriteCars()->pluck('cars.id')->all();
        }

        return view("home.index", [
            'cars' => $cars,
            'watchlistCarIds' => $watchlistCarIds
        ]);
    }
}
