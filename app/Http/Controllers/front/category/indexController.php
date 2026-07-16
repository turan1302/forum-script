<?php

namespace App\Http\Controllers\front\category;

use App\Http\Controllers\Controller;
use App\Models\BannerModel;
use App\Models\KategoriModel;
use App\Models\QuestionsModel;
use App\Models\SettingsModel;
use Illuminate\Http\Request;

class indexController extends Controller
{
    public function __construct()
    {
        if (SettingsModel::find(1)->site_durum == "0") {
            return redirect()->route('site-bakim')->send();
        }
    }

    public function index(){
        $banner = BannerModel::where("banner_anahtar","kategoriler")->first();

        $categories = KategoriModel::with("question_category")->where(array(
            "durum" => 1
        ))->orderBy("sira","asc")->paginate(9);
        return view('front.category.index',compact('categories','banner'));
    }

    // KATEGORIYE AIT SORULAR KISMI
    public function category_detail($slug){
        $kategori = KategoriModel::where(array(
            ["kat_slug","=",$slug],
            ["durum","=",1]
        ))->firstOrFail();

        $questions = QuestionsModel::select("*","questions.created_at as soru_paylasim")->leftJoin("question_category","question_category.question_id","=","questions.id")
            ->leftJoin("users","users.id","=","questions.user_id")
            ->leftJoin("kategoriler","kategoriler.id","=","question_category.category_id")
            ->where(array(
                ["question_category.category_id","=",$kategori->id],
                ["questions.status","=",1]
            ))
            ->orderByDesc("questions.id")
            ->paginate(10);


        return view('front.category.detail',compact('questions','kategori'));
    }
}
