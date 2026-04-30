<?php

namespace App\View\Components;

use Closure;
use App\Models\CarType;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class SelectCarType extends Component
{
    public Collection $Types;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        // Cache car types for 50 seconds, similar to SelectMaker
        $this->Types = cache()->remember('car_types', 50, function () {
            return CarType::orderBy('name')->get();
        });
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.select-car-type');
    }
}
