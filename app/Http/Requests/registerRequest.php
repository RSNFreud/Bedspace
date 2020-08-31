<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class registerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
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
            "password"=> 'required|min:6',
            "confirmPassword"=> 'required|same:password',
        ];
    }
}
