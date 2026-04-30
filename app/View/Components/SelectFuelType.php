<?php

namespace App\View\Components;

use Closure;
use App\Models\FuelType;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class SelectFuelType extends Component
{
    public Collection $fuelTypes;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        // Cache fuel types for 50 seconds, similar to SelectMaker
        $this->fuelTypes = cache()->remember('fuel_types', 50, function () {
            return FuelType::orderBy('name')->get();
        });
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.select-fuel-type');
    }
}
