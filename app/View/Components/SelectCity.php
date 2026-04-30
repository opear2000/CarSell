<?php

namespace App\View\Components;

use Closure;
use App\Models\City;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class SelectCity extends Component
{
    public Collection $cities;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        // Cache cities for 50 seconds, similar to SelectMaker
        $this->cities = cache()->remember('cities', 50, function () {
            return City::orderBy('name')->get();
        });
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.select-city');
    }
}
