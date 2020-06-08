<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequestPublic extends FormRequest
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
            "first_name"=>"required|min:1|max:100",
            "last_name"=>"required|min:1|max:100",
            "country"=>"required|min:1|max:100",
            "address1"=>"required|min:1|max:150",
            "address2"=>"required|min:1|max:100",
            "city"=>"required|min:1|max:100",
            "state"=>"required|min:1|max:100",
            "mobile_phone"=>"required|min:1|max:14",
            "email"=>"email|required|min:1|max:100",
            "password"=>"required|min:8|max:32",
            "postal_code"=>"required|numeric",

        ];
    }
}
