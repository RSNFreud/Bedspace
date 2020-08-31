<?php

namespace App;
use Storage, Image;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $table = 'categories';
    public $timestamps = false;
    protected $primaryKey = 'catID';



    static public function addCategory($request)
    {
        $url = strtolower($request->catName);
        $url = str_replace(" ", "-", $url);
        $cat = new self;
        $cat->catName = $request->catName;
        $cat->catDescription = $request->catDescription;
        $cat->catURL = $url;
        $cat->catImage = $request->file('featuredImage')->getClientOriginalName();
        $cat->save();
        Storage::disk("public")->putFileAs('/images',  $request->file('featuredImage'), $request->file('featuredImage')->getClientOriginalName());
        $img = Image::make(public_path() . "/images/" . $request->file('featuredImage')->getClientOriginalName());
        $img->resize(1920, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->save();
    }
    static public function editCategory($request, $url)
    {
        $url = strtolower($request->catName);
        $url = str_replace(" ", "-", $url);
        $cat = self::where("catURL", $url)->first();
        $cat->catName = $request->catName;
        $cat->catDescription = $request->catDescription;
        $cat->catURL = $url;

        if ($request->file('featuredImage')) {
            $cat->catImage = $request->file('featuredImage')->getClientOriginalName();
            Storage::disk("public")->putFileAs('/images',  $request->file('featuredImage'), $request->file('featuredImage')->getClientOriginalName());
            $img = Image::make(public_path() . "/images/" . $request->file('featuredImage')->getClientOriginalName());
            $img->resize(1920, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save();
        }
        $cat->save();
    }

}
