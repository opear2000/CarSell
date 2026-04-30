<?php

namespace App\View\Components;

use Closure;
use App\Models\Model;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class SelectModel extends Component
{
    public Collection $models;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        // Cache models for 50 seconds, similar to SelectMaker
        $this->models = cache()->remember('models', 50, function () {
            return Model::orderBy('name')->get();
        });
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.select-model');
    }
}
