<?php

namespace App\Http\Controllers\back\categories;

use App\Http\Controllers\Controller;
use App\Http\Requests\back\KategoriRequest;
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
        return view('back.categories.index');
    }

    // KATEGORILERI CAGIRALIM (DATATABLE KISMI ICIN)
    public function data()
    {
        $query = KategoriModel::all()->toQuery();  // ŞART BURADAN
        $data = DataTables::of($query)
            ->addIndexColumn()
            ->orderColumn("sortable",function ($query){   // SIRALAMA BURADAN
                $query->orderBy("sira","asc");
            })
            ->addColumn("sortable",function ($query){
                return "<i class='fa fa-bars'></i>";
            })
            ->addColumn("status", function ($query) {
                $checkedStatus = ($query->durum == 1) ? 'checked' : '';

                return "<label class='switch'>
                        <input type='checkbox' class='isActive' data-url=" . route("back.categories.isActiveSetter", $query->id) . " $checkedStatus>
                         <span class='slider round'></span>
                        </label>";
            })
            ->addColumn("actions", function ($query) {
                $edit = "<a href=" . route('back.categories.edit', $query->id) . " class='btn btn-primary btn-sm'><i class='fa fa-edit'></i></a>";
                $update = "<button type='button' class='btn btn-danger btn-sm isDelete' data-url=".route('back.categories.delete',$query->id)."><i class='fa fa-times'></i></button>";

                return $edit." ".$update;
            })
            ->rawColumns(["sortable","status", "actions"])
            ->make(true);
        return $data;
    }

    // EKLEME SAYFASI
    public function create()
    {
        return view('back.categories.create');
    }

    // EKLEME ISLEMI
    public function store(KategoriRequest $request)
    {
        // SLUG KONTROL YAPALIM
        $slug = Str::slug($request->kat_adi);
        if (KategoriModel::where("kat_slug", $slug)->count() > 0) {
            // TODO: ALERT EKLENECEK
            $alert = [
                "type" => "error",
                "title" => "Hata",
                "message" => "Aynı Kategori Zaten Mevcut"
            ];

            return redirect()->back()->with($alert);
        }

        $data = $request->except("_token");
        $kat_photo = "";
        // KATEGORI FOTOGRAFI VARSA ALDIRALIM
        if ($request->hasFile('kat_photo')){
            $kat_photo_file = $request->file('kat_photo');
            $kat_photo_name = Str::slug($request->kat_adi)."-".time();
            Image::make($kat_photo_file)->encode("webp",90)->resize(500,500)->save(public_path("storage/kategori/".$kat_photo_name.".webp"));
            $kat_photo = "kategori/".$kat_photo_name.".webp";
        }
        $data['kat_photo'] = $kat_photo;


        $ekle = KategoriModel::create($data);

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
    public function isActiveSetter(KategoriModel $item)
    {
        $data = (\request()->post('data') == "true") ? 1 : 0;
        $item->update(array(
            "durum" => $data
        ));
    }

    // GUNCELLEME SAYFASI
    public function edit(KategoriModel $item)
    {
        return view('back.categories.edit', compact('item'));
    }

    // GUNCELLEME ISLEMI
    public function update(KategoriRequest $request, KategoriModel $item)
    {

        $data = $request->except("_token");

        // KONTROL YAPTIRALIM
        $isimAl = $item->kat_adi;
        if ($isimAl != $request->kat_adi) {
            // SEO KONTROL YAPTIRALIM
            $slug = Str::slug($request->kat_adi);
            if (KategoriModel::where("kat_slug", $slug)->count() > 0) {
                $alert = [
                    "type" => "error",
                    "title" => "Hata",
                    "message" => "Aynı Kategori Zaten Mevcut"
                ];

                return redirect()->back()->with($alert);
            }else{
                $kat_photo = $item->kat_photo;

                if ($request->hasFile('kat_photo')){
                    if ($item->kat_photo != "" && File::exists("storage/".$item->kat_photo)){
                        File::delete("storage/".$item->kat_photo);
                    }

                    $kat_photo_file = $request->file('kat_photo');
                    $kat_photo_name = Str::slug($request->kat_adi)."-".time();
                    Image::make($kat_photo_file)->encode("webp",90)->resize(500,500)->save(public_path("storage/kategori/".$kat_photo_name.".webp"));
                    $kat_photo = "kategori/".$kat_photo_name.".webp";
                }
                $data['kat_photo'] = $kat_photo;

                $sonuc = $item->update($data);
            }
        } else {

            $kat_photo = $item->kat_photo;

            if ($request->hasFile('kat_photo')){
                if ($item->kat_photo != "" && File::exists("storage/".$item->kat_photo)){
                    File::delete("storage/".$item->kat_photo);
                }

                $kat_photo_file = $request->file('kat_photo');
                $kat_photo_name = Str::slug($request->kat_adi)."-".time();
                Image::make($kat_photo_file)->encode("webp",90)->resize(500,500)->save(public_path("storage/kategori/".$kat_photo_name.".webp"));
                $kat_photo = "kategori/".$kat_photo_name.".webp";
            }
            $data['kat_photo'] = $kat_photo;

            $sonuc = $item->update($data);
        }


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
    public function delete(KategoriModel $item)
    {
        if ($item->kat_photo != "" && File::exists("storage/".$item->kat_photo)){
            File::delete("storage/".$item->kat_photo);
        }

        $item->delete();
    }

    // SIRALAMA ISLEMI
    public function rankSetter(Request $request){
        parse_str($request->post('data'),$sirala);
        $sirala = $sirala['item'];

        foreach ($sirala as $k => $v){
            KategoriModel::where("id",$v)->update(array(
                "sira" => $k
            ));
        }
    }
}
