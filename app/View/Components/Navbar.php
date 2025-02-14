<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Navigation;
use Session;


class Navbar extends Component
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
        $navItems = Navigation::all();
        return view('components.navbar', ['navItems'=> $navItems, 'cart'=> Session::get("cart")]);
    }
}
