<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\addPage;
use App\Http\Requests\editPage;
use App\Navigation;
use Session;

class PagesController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        self::$viewData["pages"] = Navigation::all();
        self::$viewData["pageTitle"] .= 'Pages';
        return view('admin.pages', self::$viewData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        self::$viewData["pageTitle"] .= 'New Page';
        return view('admin.newPage', self::$viewData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(addPage $request)
    {
        Navigation::addPage($request);
        Session::flash("flash", $request->pageTitle . 'succesfully created!');
        return redirect('/admin/pages');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pageData = Navigation::where("navURL", $id)->first();
        self::$viewData["pageData"] = $pageData;
        self::$viewData["pageTitle"] .= $pageData->navName;
        return view('admin.editPage', self::$viewData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(editPage $request, $id)
    {
        Navigation::editPage($request, $id);
        Session::flash("flash", $request->pageTitle .  ' succesfully updated!');
        return redirect('/admin/pages');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $page = Navigation::where("navURL", $id)->first();
        Session::flash("flash", "Successfully deleted " . $page->navName);
        $page->delete();
    }
}
