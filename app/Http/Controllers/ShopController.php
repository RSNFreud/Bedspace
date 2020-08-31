<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Products;
use App\Categories;
use App\Cart;
use Illuminate\Support\Str;
use Session;


class ShopController extends MainController
{
    public function categories()
    {
        self::$viewData["pageTitle"] .= 'Categories';
        self::$viewData["categories"] = Categories::all();
        return view('categories', self::$viewData);
    }

    public function category($cat) {
        Products::getCategory($cat, self::$viewData);
        self::$viewData["pageTitle"] .= self::$viewData['products'][0]->catName;
        self::$viewData["category"] = self::$viewData['products'][0]->catName;
        return view('shop', self::$viewData);
    }
    public function product($cat, $item) {
        Products::getProduct($item, self::$viewData);
        self::$viewData["pageTitle"] .= self::$viewData['product'][0]->productName;
        return view('product', self::$viewData);
    }

    public function updateCart(Request $request) {
       Cart::updateCart($request);
    }
    public function deleteItem(Request $request) {
        Cart::deleteItem($request);

    }
    public function findProduct(Request $request) {
        $product = Products::getProducts($request["productName"], self::$viewData);
        if ($product->count() == 0) {
            abort(204, "No results found");
        }
        return $product;
    }

    public function clearCart() {
        Cart::clearCart();
    }

    public function cart() {
        self::$viewData["cart"] = collect(Session::get("cart"));
        $total = Cart::getTotal(self::$viewData);
        if ($total == 0) {
            self::$viewData["deliveryCharge"] = 0;
        } else {
            self::$viewData["deliveryCharge"] = 25;
        }
        self::$viewData["pageTitle"] .= 'Shopping Cart';
        self::$viewData["totalPrice"] = $total;
        return view('checkout', self::$viewData);
    }

    public function checkout() {
        if (Session::get("cart")->count() == 0) {
            return redirect('cart');
        }

        if (!Session::has("user_id")) {
            return redirect('register?redirect=cart');
        }

        Cart::checkout();
        return redirect('');
    }
}
