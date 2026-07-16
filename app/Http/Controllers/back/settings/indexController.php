<?php

namespace App\Http\Controllers\back\settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\back\SettingRequest;
use App\Models\SettingsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class indexController extends Controller
{
    public function index()
    {
        $item = SettingsModel::first();
        return view('back.settings.index', compact('item'));
    }

    // AYAR GUNCELLEME ISLEMI
    public function update(SettingRequest $request, SettingsModel $item)
    {
        // LOGO GELMIS ISE
        $data = $request->except("_token");

        if ($request->hasFile('site_icon')) {
            if ($item->site_icon != "" && File::exists("storage/" . $item->site_icon)) {
                File::delete("storage/" . $item->site_icon);
            }

            $site_icon = $request->file('site_icon');
//            $site_icon_name = Str::slug($request->site_baslik) . "-" . time() . "." . $site_icon->getClientOriginalExtension();
            $site_icon_name = Str::slug($request->site_baslik) . "-" . time();
            Image::make($site_icon)->encode('webp', 90)->resize(65, 73)->save(public_path("storage/logo/" . $site_icon_name . ".webp"));
//            $data['site_icon'] = $site_icon->storeAs("logo", $site_icon_name);
            $data['site_icon'] = "logo/" . $site_icon_name . ".webp";
        }

        if ($request->hasFile('site_favicon')) {
            if ($item->site_favicon != "" && File::exists("storage/" . $item->site_favicon)) {
                File::delete("storage/" . $item->site_favicon);
            }

            $site_favicon = $request->file('site_favicon');
            $site_favicon_name = Str::slug($request->site_baslik) . "-" . time();
            Image::make($site_favicon)->encode('webp', 90)->resize(14, 16)->save(public_path("storage/favicon/" . $site_favicon_name . ".webp"));
            $data['site_favicon'] = "favicon/" . $site_favicon_name . ".webp";
        }

        $sonuc = $item->update($data);

        if ($sonuc) {
            $alert = [
                "type" => "success",
                "title" => "Başarılı",
                "message" => "İşlem Başarılı"
            ];
        } else {
            $alert = [
                "type" => "error",
                "title" => "Hata",
                "message" => "İşlem Başarısız"
            ];
        }

        return redirect()->back()->with($alert);
    }

    // HAKKINDA SAYFASI
    public function about()
    {
        $item = SettingsModel::first();
        return view('back.settings.about', compact('item'));
    }

    // HAKKINDA GUNCELLE
    public function about_update(Request $request, SettingsModel $item)
    {
        $data = $request->except("_token");
        $sonuc = $item->update($data);

        if ($sonuc) {
            $alert = [
                "type" => "success",
                "title" => "Başarılı",
                "message" => "İşlem Başarılı"
            ];
        } else {
            $alert = [
                "type" => "error",
                "title" => "Hata",
                "message" => "İşlem Başarısız"
            ];
        }

        return redirect()->back()->with($alert);
    }

    // GİZLİLİK POLİTİKASI SAYFYASI
    public function privacy()
    {
        $item = SettingsModel::first();
        return view('back.settings.privacy', compact('item'));
    }

    // GİZLİLİK POLİTİKASI GUNCELLE
    public function privacy_update(Request $request, SettingsModel $item)
    {
        $data = $request->except("_token");
        $sonuc = $item->update($data);

        if ($sonuc) {
            $alert = [
                "type" => "success",
                "title" => "Başarılı",
                "message" => "İşlem Başarılı"
            ];
        } else {
            $alert = [
                "type" => "error",
                "title" => "Hata",
                "message" => "İşlem Başarısız"
            ];
        }

        return redirect()->back()->with($alert);
    }

    // KVKK KAPSAMI
    public function kvkk()
    {
        $item = SettingsModel::first();
        return view('back.settings.kvkk', compact('item'));
    }

    // KVKK KAPSAMI GUNCELLEME
    public function kvkk_update(Request $request, SettingsModel $item)
    {
        $data = $request->except("_token");
        $sonuc = $item->update($data);

        if ($sonuc) {
            $alert = [
                "type" => "success",
                "title" => "Başarılı",
                "message" => "İşlem Başarılı"
            ];
        } else {
            $alert = [
                "type" => "error",
                "title" => "Hata",
                "message" => "İşlem Başarısız"
            ];
        }

        return redirect()->back()->with($alert);
    }
}
