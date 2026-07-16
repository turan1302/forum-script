<?php

namespace App\Http\Requests\back;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
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
        $icon = "";
        if (request()->hasFile('site_icon')){
            $icon = "mimes:jpeg,jpg,png|max:2048";
        }

        $favicon = "";
        if (request()->hasFile('site_favicon')){
            $favicon = "mimes:jpeg,jpg,png|max:2048";
        }

        return [
            "site_url" => "required",
            "site_baslik" => "required",
            "site_desc" => "required",
            "site_keyw" => "required",
            "site_harita_durum" => "required",
            "site_mail" => "required",
            "site_durum" => "required",
            "site_icon" => $icon,
            "site_favicon" => $favicon
        ];
    }

    public function attributes()
    {
        return [
            "site_url" => "Site URL",
            "site_baslik" => "Site Başlık",
            "site_desc" => "Site Açıklama",
            "site_keyw" => "Site Anahtar Kelimeler",
            "site_harita_durum" => "Site Harita Durum",
            "site_mail" => "Site Mail",
            "site_durum" => "Site Durum",
            "site_icon" => "Site İkon (Logo)",
            "site_favicon" => "Site İkon (Favicon)"
        ];
    }
}
