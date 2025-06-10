<?php

namespace App\View\Components;

use Illuminate\View\Component;

class BackButton extends Component
{
    /**
     * The route to navigate back to.
     *
     * @var string|null
     */
    public $route;

    /**
     * Create a new component instance.
     *
     * @param  string|null  $route
     * @return void
     */
    public function __construct($route = null)
    {
        $this->route = $route;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.back-button');
    }
}
