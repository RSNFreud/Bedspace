<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\newCategory;
use App\Http\Requests\editCategory;
use App\Categories;
use Session;


class CategoryController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        self::$viewData["pageTitle"] .= 'Categories';
        self::$viewData["categories"] = Categories::all();
        return view('admin.categories', self::$viewData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        self::$viewData["pageTitle"] .= 'New Category';
        return view("admin.newCategory", self::$viewData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(newCategory $request)
    {
        Categories::addCategory($request);
        Session::flash("flash", $request->catName . ' successfully added!');
        return redirect("/admin/categories");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Categories::where('catURL', $id)->first();
        self::$viewData["categoryData"] = $category;
        self::$viewData["pageTitle"] .= $category->catName;
        return view("admin.editCategory", self::$viewData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(editCategory $request, $id)
    {
        Categories::editCategory($request, $id);
        Session::flash("flash", $request->catName . ' successfully updated!');
        return redirect("/admin/categories");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Categories::where("catURL", $id)->first();
        Session::flash("flash", $category->catName . ' successfully deleted!');
        $category->delete();
    }
}
