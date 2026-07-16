<?php

namespace App\Http\Requests\front;

use Illuminate\Foundation\Http\FormRequest;

class KayitRequest extends FormRequest
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
            "name" => "required",
            "birthday" => "required",
            "email" => "required|email|unique:users|confirmed",
            "password" => "required|min:8|max:16|confirmed"
        ];
    }

    public function attributes()
    {
        return [
            "name" => "Adınız Soyadınız",
            "birthday" => "Doğum Tarihiniz",
            "email" => "E-Mail Adresiniz",
            "password" => "Şifreniz"
        ];
    }
}
