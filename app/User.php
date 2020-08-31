<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Session, DB;

class User extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'user_id';


    static public function saveUser($data) {
        $user = new self();
        $user->fullName=$data["fullName"];
        $user->address=$data["address"];
        $user->city=$data["city"];
        $user->postcode=$data["postcode"];
        $user->emailAddress=$data["emailAddress"];
        $user->password=bcrypt($data["password"]);
        $user->save();

        Session::put("user_id", $user->id);
        Session::flash('flash', 'Account created successfully!');
    }
    static public function getData(&$viewData) {
        $orders = DB::table("orders")->where("userID", '=',Session::get("user_id"))->get();

        foreach($orders as $order) {
            $order->data = unserialize($order->data);
        }

        $userData = self::find(Session::get("user_id"));
        $viewData["userData"] = $userData;
        $viewData["orders"] = $orders;
        $viewData["pageTitle"] .= 'My Account';
    }

    static public function userUpdate($data) {
        $user = User::find(Session::get("user_id"));
        $user->fullName=$data["fullName"];
        $user->address=$data["address"];
        $user->city=$data["city"];
        $user->postcode=$data["postcode"];
        $user->emailAddress=$data["emailAddress"];

        if (!empty($data["password"])) {
            $user->password=bcrypt($data["password"]);
        }
        $user->save();
        Session::flash('flash', 'Account updated successfully!');
    }
}
