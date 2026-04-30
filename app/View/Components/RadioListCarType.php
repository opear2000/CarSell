<?php

namespace App\View\Components;

use App\Models\CarType;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Collection;

class RadioListCarType extends Component
{
    public Collection $Types;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->Types = CarType::orderBy('name')->get();
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
        return view('components.radio-list-car-type', [
            'types' => $this->Types,
        ]);
    }
}
