<?php

namespace App\View\Components;

use App\Models\FuelType;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Collection;

class RadioListFuelType extends Component
{

    public Collection $fuelTypes;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->fuelTypes = FuelType::orderBy('name')->get();
    }
    /**
     * Create a new component instance.
     */
 //   public function __construct()
 //   {
        //
 //   }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.radio-list-fuel-type', [
            'fuelTypes' => $this->fuelTypes,
        ]);
    }
}
