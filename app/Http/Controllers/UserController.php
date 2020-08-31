<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\userLogin;
use App\Http\Requests\registerRequest;
use App\Http\Requests\updateProfile;
use DB, Hash, Session;
use App\User;

class UserController extends MainController
{
    public function login(userLogin $request) {
        $products = DB::table('users')->where('emailAddress', $request['email'])->select('users.*')->first();
        $isAuthed = false;
        if ($products) {
            if (Hash::check($request['password'], $products->password)) {
                $isAuthed = true;
                Session::put("user_id",$products->user_id);
                Session::put("username",$products->fullName);
                if ($products->isAdmin) {
                    Session::put("isAdmin", $products->isAdmin);
                }
            }
        }

        if (!$isAuthed) return abort(401, 'Incorrect email and password combination!');
        Session::flash("flash", "User successfully logged in!");

    }
    public function logout() {
        Session::forget("isAdmin");
        Session::forget("username");
        Session::forget("user_id");
        Session::flash("flash", "Successfully logged out!");
        return redirect('/');
    }

    public function getRegister() {
        return view('register');
    }
    public function postRegister(registerRequest $request) {
        $saveUser = User::saveUser($request);

        $redirectLink = !empty($request['redirect']) ? $request['redirect'] : '';
        return redirect($redirectLink);
    }

    public function account() {
        if(!Session::has("user_id")) return redirect("");
        User::getData(self::$viewData);
        return view('account', self::$viewData);
    }

    public function postAccount(updateProfile $request) {
        $saveUser = User::userUpdate($request);
        User::getData(self::$viewData);
        return view('account', self::$viewData);
    }
}
