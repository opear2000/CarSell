<?php

namespace App\Http\Controllers;
use App\Models\Car;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
    //    $user = $request->session()->get('user');
    //    $all = $request->session()->all();
    //    $user2 = session('user');
    //    $request->session()->put('user', 'John Doe');
    //    session(['user' => 'edgardo']);

    //dd($user, $all);

    $cars = cache()->remember('home_cars', 60, function () {
        return Car::where('published_at', '<', now())
            ->with(['primaryImage', 'city', 'carType', 'fuelType', 'maker', 'model'])
            ->orderBy('published_at','desc')
            ->limit(30)
            ->get();
    });

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
