<?php

namespace App\View\Components;

use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class expandableuser extends Component
{
    /**
     * Create a new component instance.
     */
    public User $user;
    public function __construct($user)
    {
        $this->user=$user;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.expandable-user');
    }
}
