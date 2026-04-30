<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\CarImage;
use App\Http\Requests\StoreCarRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;

class CarController extends Controller
{
    public function index(Request $request)
    {

        $user = $request->user();

        if (! $user) {
            // No user in DB -> show empty car list rather than fatal error.
            return view('car.index', ['cars' => collect()]);
        }

        $cars = $user->cars()
        ->with(['primaryImage', 'maker', 'model'])
        ->orderBy('created_at', 'desc')
        ->paginate(15);

        return view('car.index', ['cars' => $cars]);
    }

    public function create()
    {
        return view("car.create");
    }

    public function store(StoreCarRequest $request)
    {
  //      dd($request->all());
  //      dd($request->all(), $request->file('images'));

        $data = $request->validated();

        // Extract features from the request
        $featuresData = [
            'air_conditioning' => $request->boolean('air_conditioning'),
            'power_windows' => $request->boolean('power_windows'),
            'power_door_locks' => $request->boolean('power_door_locks'),
            'abs' => $request->boolean('abs'),
            'cruise_control' => $request->boolean('cruise_control'),
            'bluetooth_connectivity' => $request->boolean('bluetooth_connectivity'),
            'remote_start' => $request->boolean('remote_start'),
            'gps_navigation' => $request->boolean('gps_navigation'),
            'heated_seats' => $request->boolean('heated_seats'),
            'climate_control' => $request->boolean('climate_control'),
            'rear_parking_sensors' => $request->boolean('rear_parking_sensors'),
            'leather_seats' => $request->boolean('leather_seats'),
        ];

        // $images = $request->file('images', []);
         $images = $request->file('images') ?: [];

        // Remove features from car data
        unset(
            $data['air_conditioning'],
            $data['power_windows'],
            $data['power_door_locks'],
            $data['abs'],
            $data['cruise_control'],
            $data['bluetooth_connectivity'],
            $data['remote_start'],
            $data['gps_navigation'],
            $data['heated_seats'],
            $data['climate_control'],
            $data['rear_parking_sensors'],
            $data['leather_seats']
        );

        $data['user_id'] = $request->user()->id;
        $car = Car::create($data);

        $car->features()->create($featuresData);

        // Handle image uploads
        //if ($request->hasFile('images')) {
        //    $position = 1;
        //    foreach ($request->file('images') as $image) {
        //        $path = $image->store('images', 'public');
        //        CarImage::create([
        //            'car_id' => $car->id,
        //            'image_path' => $path,
        //            'position' => $position++
        //        ]);
        //    }
        
        foreach ($images as $i => $image) {
            if ($image->isValid()) {
                $path = $image->store('images', 'public');
                // DEBUG: Log the path after storing
                \Log::info('Stored image path', ['path' => $path]);
                $carImage = $car->images()->create(['image_path' => $path, 'position' => $i + 1]);
                // DEBUG: Log the CarImage creation result
                \Log::info('Created CarImage', ['car_image' => $carImage]);
            }
        }

        return redirect()->route('car.index')->with('success', 'Car created successfully.');
    }

    public function show( Request $request, Car $car)                  
    {
        if ($car->published_at > now()) {
            abort(404);
        }   
        $isInWatchlist = false;
        if ($request->user()) {
            $isInWatchlist = $request->user()
                ->favoriteCars()
                ->where('cars.id', $car->id)
                ->exists();
        }

        return view("car.show", ["car" => $car, 'isInWatchlist' => $isInWatchlist]);
    }
    
    
    public function edit(Car $car)                  
    {
        Gate::authorize('update-car', $car);
        return view("car.edit", ["car" => $car]);
    }

    public function update(StoreCarRequest $request, Car $car)                  
    {
        Gate::authorize('update-car', $car);

        $data = $request->validated();

        // Extract features from the request
        $featuresData = [
            'air_conditioning' => $request->boolean('air_conditioning'),
            'power_windows' => $request->boolean('power_windows'),
            'power_door_locks' => $request->boolean('power_door_locks'),
            'abs' => $request->boolean('abs'),
            'cruise_control' => $request->boolean('cruise_control'),
            'bluetooth_connectivity' => $request->boolean('bluetooth_connectivity'),
            'remote_start' => $request->boolean('remote_start'),
            'gps_navigation' => $request->boolean('gps_navigation'),
            'heated_seats' => $request->boolean('heated_seats'),
            'climate_control' => $request->boolean('climate_control'),
            'rear_parking_sensors' => $request->boolean('rear_parking_sensors'),
            'leather_seats' => $request->boolean('leather_seats'),
        ];

        // Remove features from car data
        unset(
            $data['air_conditioning'],
            $data['power_windows'],
            $data['power_door_locks'],
            $data['abs'],
            $data['cruise_control'],
            $data['bluetooth_connectivity'],
            $data['remote_start'],
            $data['gps_navigation'],
            $data['heated_seats'],
            $data['climate_control'],
            $data['rear_parking_sensors'],
            $data['leather_seats']
        );

        $car->update($data);

        // Update or create features
        $car->features()->updateOrCreate([], $featuresData);

        return redirect()->route('car.index')->with('success', 'Car updated successfully.');
    }

    public function destroy(Car $car)                  
    {
        Gate::authorize('update-car', $car);

        $car->delete();
        return redirect()->route('car.index')->with('success', 'Car deleted successfully.');
    }

    public function search(Request $request)                  
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

        $sort = $request->input('sort', 'published_at');
        $sortDirection = 'asc';
        if (str_starts_with($sort, '-')) {
            $sortDirection = 'desc';
            $sort = substr($sort, 1);
        }

        $query = Car::select('cars.*')->where('published_at', '<', now())
        ->with(['primaryImage', 'city', 'carType', 'fuelType', 'maker', 'model'])
        ->orderBy($sort, $sortDirection);

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


/* select only California

        $query->join('cities', 'cities.id', '=', 'cars.city_id')
        ->where('cities.state_id', 1);
*/
 /*       $carCount = $query->count();
        $cars = $query->limit(30)->get();
        return view("car.search", ['cars' => $cars,'carCount'=> $carCount]);
*/
        $cars = $query->paginate(15)->withQueryString()->appends(request()->query());
        $watchlistCarIds = $request->user()
            ? $request->user()->favoriteCars()->pluck('cars.id')->all()
            : [];

        return view("car.search", ['cars' => $cars, 'watchlistCarIds' => $watchlistCarIds]);
    }

    public function watchlist(Request $request)
    {
        $user = $request->user();

        if (! $user) {
            return view('car.watchlist', ['cars' => collect()]);
        }

        $cars = Car::query()
            ->whereHas('favoredUsers', function ($query) use ($user) {
                $query->where('users.id', $user->id);
            })
            ->with(['primaryImage', 'city', 'carType', 'fuelType', 'maker', 'model'])
            ->orderByDesc('cars.created_at')
            ->paginate(15);

        return view('car.watchlist', ['cars' => $cars]);
    }

    public function storeWatchlist(Request $request, Car $car)
    {
        $request->user()->favoriteCars()->syncWithoutDetaching([$car->id]);

        return back()->with('success', 'Car added to your watchlist.');
    }

    public function destroyWatchlist(Request $request, Car $car)
    {
        $request->user()->favoriteCars()->detach($car->id);

        return back()->with('success', 'Car removed from your watchlist.');
    }

    public function carImages(Car $car)
    {
        Gate::authorize('update-car', $car);

        $images = $car->images()->orderBy('position')->get();
        return view('car.images', ['car' => $car, 'images' => $images]);
    }

    public function updateImages(Request $request, Car $car)
    {
        Gate::authorize('update-car', $car);

        $request->validate([
            'new_images' => 'nullable|array|max:10',
            'new_images.*' => 'image|mimes:webp,jpeg,png,jpg,gif|max:200',
            'positions' => 'nullable|array',
            'positions.*' => 'integer',
            'delete_images' => 'nullable|array',
            'delete_images.*' => 'integer|exists:car_images,id',
        ], [
            'new_images.*.max' => 'Each image must not exceed 200KB',
        ]);

        // Handle new image uploads
        $newImages = $request->file('new_images') ?: [];
        foreach ($newImages as $i => $image) {
            if ($image->isValid()) {
                $path = $image->store('images', 'public');
                $car->images()->create(['image_path' => $path, 'position' => $car->images()->max('position') + 1]);
            }
        }

        // Handle position updates
        $positions = $request->input('positions', []);
        foreach ($positions as $imageId => $position) {
            $car->images()->where('id', $imageId)->update(['position' => $position]);
        }

        // Handle deletions
        $deleteImageIds = $request->input('delete_images', []);
        if (!empty($deleteImageIds)) {
            foreach ($deleteImageIds as $imageId) {
                $image = CarImage::find($imageId);
                if ($image && $image->car_id == $car->id) {
                    Storage::disk('public')->delete($image->image_path);
                    $image->delete();
                }
            }
        }

        return redirect()->route('car.images', $car)->with('success', 'Car images updated successfully.');
    }
}
