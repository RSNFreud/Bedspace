<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class newProduct extends FormRequest
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
    public function rules(Request $request)
    {
        return [
            'itemName' => 'required|unique:products,productName',
            'price' => 'required|numeric',
            'featuredImage' => 'required|image',
            'itemDescription' => 'required',
            'category' => 'required',
            'dimensions' => 'required',
            'weight' => 'required',
            'deliveryTime' => 'required'
        ];
    }
}
