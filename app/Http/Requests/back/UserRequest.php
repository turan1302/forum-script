<?php

namespace App\Http\Requests\back;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $photo = "";
        if (request()->hasFile('photo')){
            $photo = "mimes:jpeg,jpg,png|max:2048";
        }

        $password = "";
        if (request()->post('password') != ""){
            $password = "required|min:8|max:16|confirmed";
        }

        return [
            "nickname" => "required",
            "name" => "required",
            "photo" => $photo,
            "birthday" => "required",
            "email" => "required|email",
            "password" => $password
        ];
    }

    public function attributes()
    {
        return [
            "nickname" => "Kullanıcı Adınız",
            "name" => "Adınız Soyadınız",
            "photo" => "Profil Fotoğrafınız",
            "birthday" => "Doğum Tarihi",
            "email" => "E-Mail Adresiniz",
            "password" => "Şifre"
        ];
    }
}
