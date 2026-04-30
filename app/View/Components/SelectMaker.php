<?php

namespace App\View\Components;

use Closure;
use App\Models\Maker;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SelectMaker extends Component
{
    public $makers;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        // Put info in cache in default store for 50 seconds
        $this->makers = cache()->remember('makers', 50, function () {
            return Maker::orderBy('name')->get();
        });
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.select-maker');
    }
}
