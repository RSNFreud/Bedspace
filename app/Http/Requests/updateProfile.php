<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Session;

class updateProfile extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Session::has("user_id")) return true;
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "fullName"=> 'required',
            "address"=> 'required',
            "city"=>'required',
            "postcode"=> 'required',
            "emailAddress"=> 'required|email|unique:users,emailAddress',
            "password"=> 'nullable|min:6',
            "confirmPassword"=> 'same:password',
        ];
    }
}
