<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProduct extends FormRequest
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
    { //dd($this->product);
        return [
            'product_name' => ['required', 'string', 'max:255',\Illuminate\Validation\Rule::unique('products')->ignore($this->product)],
            'product_price' => ['required','regex:/^\d*(\.\d{1,2})?$/'],
            'product_desccription' => ['required', 'string' ],
            'product_image.*' => ['required','image','mimes:jpeg,jpg,png','file','max:2048']
        ];
    }
}
