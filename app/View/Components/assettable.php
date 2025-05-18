<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class expandableasset extends Component
{
    /**
     * Create a new component instance.
     */
    public $asset;
    public function __construct($asset)
    {
        $this->asset=$asset;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.expandable-asset');
    }
}
