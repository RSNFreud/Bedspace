<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Session;


class MainController extends Controller
{

    static public $viewData = ["pageTitle" => 'BedSpace | '];

    public function __construct()
    {
        if (!Session::has("cart")) {
            Session::put("cart", collect([]));
        }
        return view('master');
    }
}
