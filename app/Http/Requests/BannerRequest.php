<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest
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
        $banner_foto = "";
        if (request()->hasFile('banner_foto')){
            $banner_foto = "mimes:jpeg,jpg,png|max:2048";
        }

        return [
            "banner_baslik" => "required",
            "banner_aciklama" => "required",
            "banner_foto" => $banner_foto
        ];
    }

    public function attributes()
    {
        return [
            "banner_baslik" => "Banner Başlık",
            "banner_aciklama" => "Banner Açıklama",
            "banner_foto" => "Banner Fotoğraf"
        ];
    }
}
