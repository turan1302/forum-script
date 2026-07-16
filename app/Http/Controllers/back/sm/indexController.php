<?php

namespace App\Http\Controllers\back\sm;

use App\Http\Controllers\Controller;
use App\Http\Requests\back\KategoriRequest;
use App\Http\Requests\back\SMRequest;
use App\Models\BannerModel;
use App\Models\KategoriModel;
use App\Models\SosyalMedyaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;
use Yajra\DataTables\DataTables;

class indexController extends Controller
{
    public function index()
    {
        return view('back.sm.index');
    }

    // KATEGORILERI CAGIRALIM (DATATABLE KISMI ICIN)
    public function data()
    {
        $query = SosyalMedyaModel::query();  // ŞART BURADAN
        $data = DataTables::of($query)
            ->addIndexColumn()
            ->orderColumn("sortable",function ($query){   // SIRALAMA BURADAN
                $query->orderBy("sm_sira","asc");
            })
            ->addColumn("sortable",function ($query){
                return "<i class='fa fa-bars'></i>";
            })
            ->addColumn("sm_durum", function ($query) {
                $checkedStatus = ($query->sm_durum == 1) ? 'checked' : '';

                return "<label class='switch'>
                        <input type='checkbox' class='isActive' data-url=" . route("back.sm.isActiveSetter", $query->id) . " $checkedStatus>
                         <span class='slider round'></span>
                        </label>";
            })
            ->addColumn("actions", function ($query) {
                $edit = "<a href=" . route('back.sm.edit', $query->id) . " class='btn btn-primary btn-sm'><i class='fa fa-edit'></i></a>";
                $update = "<button type='button' class='btn btn-danger btn-sm isDelete' data-url=".route('back.sm.delete',$query->id)."><i class='fa fa-times'></i></button>";

                return $edit." ".$update;
            })
            ->rawColumns(["sortable","sm_durum", "actions"])
            ->make(true);
        return $data;
    }

    // EKLEME SAYFASI
    public function create()
    {
        return view('back.sm.create');
    }

    // EKLEME ISLEMI
    public function store(SMRequest $request)
    {

        $data = $request->except("_token");
        $ekle = SosyalMedyaModel::create($data);

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
    public function isActiveSetter(SosyalMedyaModel $item)
    {
        $data = (\request()->post('data') == "true") ? 1 : 0;
        $item->update(array(
            "sm_durum" => $data
        ));
    }

    // GUNCELLEME SAYFASI
    public function edit(SosyalMedyaModel $item)
    {
        return view('back.sm.edit', compact('item'));
    }

    // GUNCELLEME ISLEMI
    public function update(SMRequest $request, SosyalMedyaModel $item)
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

    // SİLME İSLEMI
    public function delete(SosyalMedyaModel $item)
    {
        $item->delete();
    }

    // SIRALAMA ISLEMI
    public function rankSetter(Request $request){
        parse_str($request->post('data'),$sirala);
        $sirala = $sirala['item'];

        foreach ($sirala as $k => $v){
            SosyalMedyaModel::where("id",$v)->update(array(
                "sm_sira" => $k
            ));
        }
    }
}
