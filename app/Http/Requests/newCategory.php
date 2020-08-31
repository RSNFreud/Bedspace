<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class newCategory extends FormRequest
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
            'catName' => 'required|unique:categories,catName',
            'featuredImage' => 'required|image',
            'catDescription' => 'required'
        ];
    }

   public function attributes() {
        return [
            'catName' => 'category name',
            'catDescription' => 'category description'
        ];
   }
}
