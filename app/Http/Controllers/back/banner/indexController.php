<?php

namespace App\Http\Controllers\back\banner;

use App\Http\Controllers\Controller;
use App\Http\Requests\BannerRequest;
use App\Models\BannerModel;
use App\Models\KategoriModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;
use Yajra\DataTables\DataTables;

class indexController extends Controller
{
    public function index()
    {
        return view('back.banners.index');
    }

    // KATEGORILERI CAGIRALIM (DATATABLE KISMI ICIN)
    public function data()
    {
        $query = BannerModel::all();  // ŞART BURADAN
        $data = DataTables::of($query)
            ->addIndexColumn()
            ->addColumn("banner_resim", function ($query) {
                $sonuc = "";
                if ($query->banner_foto != "" && File::exists("storage")) {
                    $sonuc = "<img width=50 height=50 src='" . asset('storage/' . $query->banner_foto) . "'>";
                } else {
                    $sonuc = "<img width='50' height='50' src='" . asset('storage/resim-yok.webp') . "'>";
                }
                return $sonuc;
            })
            ->addColumn("banner_durum", function ($query) {
                $checkedStatus = ($query->banner_durum == 1) ? 'checked' : '';

                return "<label class='switch'>
                        <input type='checkbox' class='isActive' data-url=" . route("back.banners.isActiveSetter", $query->id) . " $checkedStatus>
                         <span class='slider round'></span>
                        </label>";
            })
            ->addColumn("actions", function ($query) {
                $edit = "<a href=" . route('back.banners.edit', $query->id) . " class='btn btn-primary btn-sm'><i class='fa fa-edit'></i></a>";
                $update = "<button type='button' class='btn btn-danger btn-sm isDelete' data-url=" . route('back.banners.delete', $query->id) . "><i class='fa fa-times'></i></button>";

                return $edit . " " . $update;
            })
            ->rawColumns(["banner_resim", "banner_durum", "actions"])
            ->make(true);
        return $data;
    }

    // EKLEME SAYFASI
    public function create()
    {
        return view('back.banners.create');
    }

    // EKLEME ISLEMI
    public function store(BannerRequest $request)
    {

        $data = $request->except("_token");
        $kat_photo = "";
        // KATEGORI FOTOGRAFI VARSA ALDIRALIM
        if ($request->hasFile('banner_foto')) {
            $banner_foto_file = $request->file('banner_foto');
            $banner_foto_name = Str::slug($request->banner_baslik) . "-" . time();
            Image::make($banner_foto_file)->encode("webp", 90)->resize(500, 500)->save(public_path("storage/banner/" . $banner_foto_name . ".webp"));
            $kat_photo = "banner/" . $banner_foto_name . ".webp";
        }
        $data['banner_foto'] = $kat_photo;
        $ekle = BannerModel::create($data);

        if ($ekle) {
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

    // DURUM GUNCELLEME ISLEMI
    public function isActiveSetter(BannerModel $item)
    {
        $data = (\request()->post('data') == "true") ? 1 : 0;
        $item->update(array(
            "banner_durum" => $data
        ));
    }

    // GUNCELLEME SAYFASI
    public function edit(BannerModel $item)
    {
        return view('back.banners.edit', compact('item'));
    }

    // GUNCELLEME ISLEMI
    public function update(BannerRequest $request, BannerModel $item)
    {
        $data = $request->except("_token");
        $banner_foto = $item->banner_foto;

        if ($request->hasFile('banner_foto')) {
            if ($item->banner_foto != "" && File::exists("storage/" . $item->banner_foto)) {
                File::delete("storage/" . $item->banner_foto);
            }
            $banner_foto_file = $request->file('banner_foto');
            $banner_foto_name = Str::slug($request->banner_baslik) . "-" . time();
            Image::make($banner_foto_file)->encode("webp", 90)->resize(500, 500)->save(public_path("storage/banner/" . $banner_foto_name . ".webp"));
            $banner_foto = "banner/" . $banner_foto_name . ".webp";
        }

        $data['banner_foto'] = $banner_foto;

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

    // SİLME İSLEMI
    public function delete(BannerModel $item)
    {
        if ($item->banner_foto != "" && File::exists("storage/" . $item->banner_foto)) {
            File::delete("storage/" . $item->banner_foto);
        }

        $item->delete();
    }
}
