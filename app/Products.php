<?php

namespace App;
use DB, Session, Storage, Image;


use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $table = 'products';
    public $timestamps = false;

    static public function getCategory($cat, &$viewData){
        $products = DB::table('products as p')->join('categories as c', 'c.catName' ,'=', 'p.category')->select('p.*', 'c.catName', 'c.catURL')->where('c.catURL', $cat)->get();

        if ($products->count() == 0) {
             abort(404);
        }
        $viewData["products"] = $products;
    }
    static public function getProduct($product, &$viewData){
        $products = DB::table('products as p')->where('url', $product)->leftJoin('productimages as Images', 'p.id', '=', 'Images.productID')->join('categories as c', 'c.catName', 'p.category')->select('p.*', 'Images.fileName','c.catURL')->get();
        if ($products->count() == 0) {
             abort(404);
        }

        foreach(Session::get("cart") as $item) {
            if ($products[0]->id == $item->id) {
                $viewData["inCart"] = $item;
            }
        }
        $viewData["product"] = $products;

        self::getCategory($products[0]->catURL, $viewData);
    }
    static public function viewProduct($product){
        $products = DB::table('products as p')->where('url', $product)->leftJoin('productimages as Images', 'p.id', '=', 'Images.productID')->join('categories as c', 'c.catName', 'p.category')->select('p.*', 'Images.fileName','c.catURL')->get();
        if ($products->count() == 0) {
             abort(404);
        }
        return $products;
    }
    static public function editProduct($request, $id){
        $url = strtolower($request->itemName);
        $url = str_replace(" ", "-", $url);
        $product = self::where("url", "=", $id)->first();
        $product->productName = $request->itemName;
        $product->price = $request->price;
        $product->description = $request->itemDescription;
        $product->category = $request->category;
        $product->dimensions = $request->dimensions;
        $product->weight = $request->weight;
        $product->deliveryTime = $request->deliveryTime;
        $product->url = $url;

        if ($request->file()) {
            $product->displayImage = $request->file('featuredImage')->getClientOriginalName();
            Storage::disk("public")->putFileAs('/images',  $request->file('featuredImage'), $request->file('featuredImage')->getClientOriginalName());
            $img = Image::make(public_path() . "/images/" . $request->file('featuredImage')->getClientOriginalName());
            $img->resize(1920, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save();
        }
        $product->save();

        if(Session::has("productImages")) {
            $files = Session::get("productImages");
            $productImages = DB::table('products as p')->where("url", "=", $id)->leftJoin('productimages as images', 'p.id', '=', 'images.productID')->select('images.*')->get();
            foreach ($productImages as $image) {
                if ($image->fileName == null) continue;
                if (array_search($image->fileName, array_column($files, 'name')) !== false) continue;
                DB::table("productimages")->where("fileName", "=", $image->fileName)->where("productID", "=", $image->productID)->delete();
                if (!Storage::disk("public")->has('images/' . $image->fileName)) continue;
                Storage::disk("public")->delete($image->fileName);
                 // If productImage is deleted or new
            }
            if (count($files) == 0) return;
            for ($x=0; $x != count($files); $x++){
                if (Storage::disk('public')->has('images/' . $files[$x]["name"])) continue;
                $checkDB = DB::table("productimages")->where("fileName", "=",$files[$x]["name"])->where("productID", "=", $product->id)->get();
                if ($checkDB->count() != 0) continue; // If the productImage is not in the database...
                DB::table('productimages')->insert(['productID' => $product->id, 'fileName'=>$files[$x]["name"]]);
                $img = Image::make(storage_path() . "/app/images/" . $files[$x]["name"]);
                $img->resize(1920, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save();
                Storage::disk("public")->putFileAs('/images',  storage_path() . '/app/images/' . $files[$x]["name"],  $files[$x]["name"]);
                Storage::delete($files[$x]["name"]);
            }
        }
        Session::flash('flash', 'Product successfully updated!');

    }


    static public function getProducts($productName, &$viewData) {
        // Gets all the products with category name and url joined

        $string = '%' . $productName . '%';
        $products = DB::table('products')->join('categories as c', 'c.catName', 'category')->select("c.catURL", "products.*")->where('productName', 'like', $string)->get();
        return $products;
    }

    static public function addProduct($request) {
        // Adds a new product
        $url = strtolower($request->itemName);
        $url = str_replace(" ", "-", $url);
        $product = new self;
        $product->productName = $request->itemName;
        $product->price = $request->price;
        $product->description = $request->itemDescription;
        $product->category = $request->category;
        $product->dimensions = $request->dimensions;
        $product->weight = $request->weight;
        $product->deliveryTime = $request->deliveryTime;
        $product->url = $url;
        $product->displayImage = $request->file('featuredImage')->getClientOriginalName();
        $product->save();

        Storage::disk("public")->putFileAs('/images',  $request->file('featuredImage'), $request->file('featuredImage')->getClientOriginalName());
        $img = Image::make(public_path() . "/images/" . $request->file('featuredImage')->getClientOriginalName());
        $img->resize(1920, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->save();
        if(Session::has("productImages")) {
            $files = Session::get("productImages");
            for ($x=0; $x!=count($files);$x++){
                DB::table('productimages')->insert(['productID' => $product->id, 'fileName'=>$files[$x]["name"]]);
                $img = Image::make(storage_path() . "/app/images/" . $files[$x]["name"]);
                $img->resize(1920, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save();
                Storage::disk("public")->putFileAs('/images',  storage_path() . '/app/images/' . $files[$x]["name"],  $files[$x]["name"]);
                Storage::delete($files[$x]["name"]);
                }
        }
    }
}
