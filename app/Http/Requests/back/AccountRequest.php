<?php

namespace App\Http\Requests\back;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class AccountRequest extends FormRequest
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
        // ŞİFRE GUNCELLEME KISMI
        $password = "";
        if ($request->current_password != "" && $request->password != ""){
            $password = "min:8|max:16|confirmed";
        }

        $email = "";
        // KULLANICI EMAIL GUNCELLEME KISMI
        if ($request->email != auth()->user()->email){
            $email = "required|email|unique:users";
        }else{
            $email = "required|email";
        }

        // KULLANICI TELEFON NUMARASI GUNCELLEME KISMI
        $phone = "";
        if ($request->phone != auth()->user()->phone){
            $phone = "unique:users";
        }else{
            $phone = "";
        }

        $photo = "";
        if ($request->hasFile('photo')){
            $photo = "mimes:jpeg,jpg,png|max:2048";
        }

        return [
            "name" => "required",
            "email" => $email,
            "phone" => $phone,
            "birthday" => "required",
            "password" => $password,
            "photo" => $photo
        ];
    }

    public function attributes()
    {
        return [
            "photo" => "Profil Fotosu",
            "name" => "Adınız Soyad",
            "email" => "E-Mail Adresi",
            "phone" => "Telefon Numarası",
            "birthday" => "Doğum Tarihi",
            "password" => "Şifre",
            "nickname" => "Nickname"
        ];
    }
}
