<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Session;

class ShoppingCart extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.shopping-cart', ['cart'=> Session::get("cart")]);
    }
}
