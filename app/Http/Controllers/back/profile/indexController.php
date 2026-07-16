<?php

namespace App\Http\Controllers\back\profile;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class indexController extends Controller
{
    public function index()
    {
        return view('back.profile.index');
    }

    // GUNCELLEME KISMI
    public function update(Request $request, User $item)
    {
        // KULLANICI ADI ARAŞTIRMA
        if ($item->nickname != $request->nickname) {
            $request->validate(array(
                "nickname" => "unique:users"
            ), array(), array(
                "nickname" => "Kullanıcı Adı"
            ));
        }

        // RESIM KONTROL ETTIRME
        $photo = auth()->user()->photo;
        if ($request->hasFile('photo')) {
            if (auth()->user()->photo != "" && File::exists("storage/" . auth()->user()->photo)) {
                File::delete("storage/" . auth()->user()->photo);
            }

            $file = $request->file('photo');
            $file_name = Str::slug(auth()->user()->name) . "-" . time();
            Image::make($file)->encode('webp', 90)->resize(512, 512)->save(public_path("storage/kullanici/" . $file_name . ".webp"));
            $photo = "kullanici/".$file_name.".webp";
        }

        // PASSWOWRD AYARLAMA KISMI
        $pasword = ($request->password != "") ? Hash::make($request->password) : $item->password;

        $data = $request->except("_token");
        $data['photo'] = $photo;
        $data['password'] = $pasword;

        $sonuc = $item->update($data);

        if ($sonuc) {
            return redirect()->back()->with(array(
                "type" => "success",
                "title" => "Başarılı",
                "message" => "Hesap Bilgileriniz Başarıyla Güncellendi"
            ));
        } else {
            return redirect()->back()->with(array(
                "type" => "error",
                "title" => "Hata",
                "message" => "Hesap Bilgileriniz Güncellenirken Hata Oluştu"
            ));
        }
    }
}
