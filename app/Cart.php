<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Products;
use Session, DB;

class Cart extends Model
{
    static public function clearCart() {
        Session::forget("cart");
        Session::put("cart", collect([]));
    }
    static public function updateCart($request) {
        $product = Products::find($request['product']);
        $quantity = $request['quantity'];
        $product->quantity = 1;

        $count = 0;
        foreach (Session::get("cart") as $item){
            if ($product->id == $item->id) {
                if ($quantity >= 0) {
                    Session::flash("flash", 'Cart updated succesfully!');
                    return $item->quantity=$quantity;
                } else {
                    Session::flash("flash", 'Cart updated succesfully!');
                    return $item->quantity+=1;
                }
            }
            $count++;
        }
        Session::push("cart", $product);
        Session::flash("flash", $product->productName . ' succesfully added to cart!');
    }

    static public function deleteItem($request) {
        $product = Products::find($request['productID']);
        Session::put("cart", Session::get("cart")->whereNotIn('id', $product->id));
        Session::flash("flash", $product->productName . ' succesfully removed from cart!');

    }

    static public function getTotal() {
        // Get the total sum of all the items inside the cart
        $priceArray = collect([]);

        foreach (Session::get("cart") as $item) {
            $priceArray->push($item['price'] * $item['quantity']);
        }
        return $priceArray->sum();

    }

    static public function checkout() {
        $cart = Session::get("cart")->toJson();
        $cart = json_decode($cart, true);
        $cart = serialize($cart);
        DB::table('orders')
        ->insert(['data' => $cart, 'userID' => Session::get("user_id"), 'total'=> self::getTotal()]);
        self::clearCart();
        Session::flash("flash", "Your order has been submitted succesfully!");
    }
}
