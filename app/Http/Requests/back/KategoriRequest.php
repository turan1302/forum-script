<?php

namespace App\Http\Requests\back;

use Illuminate\Foundation\Http\FormRequest;

class KategoriRequest extends FormRequest
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
        $kat_photo = "";
        if (request()->hasFile('kat_photo')){
            $kat_photo = "mimes:jpeg,jpg,png|max:2048";
        }

        return [
            "kat_adi" => "required",
            "kat_desc" => "required",
            "kat_keyw" => "required",
            "kat_photo" => $kat_photo
        ];
    }

    public function attributes()
    {
        return [
            "kat_adi" => "Kategori Adı",
            "kat_desc" => "Kategori Açıklama",
            "kat_keyw" => "Kategori Anahtar Kelime",
            "kat_photo" => "Kategori Fotoğraf"
        ];
    }
}
