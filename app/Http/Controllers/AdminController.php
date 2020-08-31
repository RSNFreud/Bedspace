<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session, DB;
use App\Orders;
use App\User;

class AdminController extends Controller
{
    static public $viewData = ["pageTitle" => 'BedSpace Admin | '];

    static public function orders()
    {
        $orderCompiled = [];
        $orders = DB::table("orders")->get();
        foreach ($orders as $order) {

            $orderItem["userDetails"] = User::find($order->userID);
            $orderItem["orderData"] = unserialize($order->data);
            $orderItem["price"] = $order->total;
            $orderItem["date"] = date('d/m/Y h:m', strtotime($order->datePlaced));
            array_push($orderCompiled, $orderItem);
        }
        self::$viewData["orders"] = $orderCompiled;
        self::$viewData["pageTitle"] .= 'Orders';
        // dd($orderCompiled);
        return view('admin.orders', self::$viewData);
    }
}
