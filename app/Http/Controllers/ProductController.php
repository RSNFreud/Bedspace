<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Categories;
use App\Http\Requests\newProduct;
use App\Http\Requests\editProduct;
use Session, Storage, Image;
use App\Products;

class ProductController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Session::forget("productImages");
        self::$viewData["products"] = Products::all();
        self::$viewData["pageTitle"] .= 'Products';
        return view("admin.products", self::$viewData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Session::has("productImages")) {
            $productImages = [];
            foreach(Session::get("productImages") as $image) {
                if (!Storage::has("images/" . $image["name"])) continue;
                $file['name'] = $image;
                $file['url'] = asset('storage') . '/' . $image["name"];
                $file['size'] = Storage::size("images/" . $image["name"]);
                array_push($productImages, $file);
            }
            self::$viewData["productImages"] = json_encode($productImages);

        } else {
            self::$viewData["productImages"] = '[]';
        }
        self::$viewData["categories"] = Categories::all();
        self::$viewData["pageTitle"] .= 'New Product';
        return view("admin.newProduct", self::$viewData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(newProduct $request)
    {
        Products::addProduct($request);
        Session::forget("productImages");
        $directories = Storage::files('images');
        foreach($directories as $image) {
            Storage::delete($image);
        }
        return redirect("/admin/products");
    }


    public function addImage(Request $request) {
        if (!Session::has("isAdmin")) abort();
        foreach ($request->file as $requestFile) {
            Storage::putFileAs('/images', $requestFile, $requestFile->getClientOriginalName());
            $file['name'] = $requestFile->getClientOriginalName();
            $file['url'] = asset('storage') . '/' . $requestFile->getClientOriginalName();
            $file['size'] = Storage::size("images/" . $requestFile->getClientOriginalName());
            Session::push("productImages", $file);
        }
    }

    public function removeImage(Request $request) {
        if (!Session::has("isAdmin")) abort();
        $image = implode(Arr::divide($request->input())[0]);
        $image = str_replace("_", ".", $image);
        $index = 0;
        for ($x = 0; $x != count(Session::get("productImages")); $x++) {
            if (array_values(Session::get("productImages"))[$x]['name'] == $image) $index = $x;
        }
        Session::put("productImages", array_values(Arr::except(Session::get("productImages"), $index)));
        Storage::delete('images/' . $image);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $productImages = [];
        $product = Products::viewProduct($id);
        if (Session::has("productImages")) {
            foreach(Session::get("productImages") as $image) {
                $file['name'] = $image["name"];
                $file['url'] =  $image["url"];
                $file['size'] = $image["size"];
                array_push($productImages, $file);
            }
        } else {
            foreach ($product as $data) {
                if ($data->fileName) {
                    $file['name'] = $data->fileName;
                    $file['url'] = asset('images') . '/' . $data->fileName;
                    $file['size'] = Storage::disk("public")->size("images/" . $data->fileName);
                    Session::push("productImages", $file);
                    array_push($productImages, $file);
                }
            }
        }

        if (count($productImages) == 0) {
            self::$viewData["productImages"] = [];
        }
        self::$viewData["productImages"] = json_encode($productImages);
        self::$viewData["categories"] = Categories::all();
        self::$viewData["productData"] = $product->first();
        self::$viewData["pageTitle"] .= $product->first()->productName;
        return view("admin.editProduct", self::$viewData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(editProduct $request, $id)
    {
        Products::editProduct($request, $id);
        Session::forget("productImages");
        $directories = Storage::files('images');
        foreach($directories as $image) {
            Storage::delete($image);
        }
        return redirect("/admin/products");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Products::where("url", $id)->first();
        Session::flash("flash", $product->productName . ' successfully deleted!');
        $product->delete();
    }
}
