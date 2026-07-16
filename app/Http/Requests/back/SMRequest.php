<?php

namespace App\Http\Requests\back;

use Illuminate\Foundation\Http\FormRequest;

class SMRequest extends FormRequest
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
            "sm_anahtar" => "required",
            "sm_baslik" => "required",
            "sm_icon" => "required",
            "sm_url" => "required"
        ];
    }

    public function attributes()
    {
        return [
            "sm_anahtar" => "Sosyal Medya Anahtar",
            "sm_baslik" => "Sosyal Medya Başlık",
            "sm_icon" => "Sosyal Medya İkon",
            "sm_url" => "Sosyal Medya Url",
        ];
    }
}
