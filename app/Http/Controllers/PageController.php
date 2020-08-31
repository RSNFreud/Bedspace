<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Navigation;

class PageController extends MainController
{
    public function index()
    {
        self::$viewData["pageTitle"] .= 'Home';
        return view('index', self::$viewData);
    }
    public function showPage(Request $request)
    {
        $pageContents = Navigation::where("navURL", $request->route('page'))->first();
        if (!$pageContents) abort('404');
        self::$viewData["pageTitle"] .= $pageContents->navName;
        self::$viewData["pageContents"] = $pageContents;
        return view('index', self::$viewData);
    }
}
