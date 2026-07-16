<?php

namespace App\Http\Controllers\front\search;

use App\Http\Controllers\Controller;
use App\Models\BannerModel;
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

    // ARAMA YAPILACAK
    public function search(Request $request)
    {
        $banner = BannerModel::where("banner_anahtar","arama")->first();

       $questions = QuestionsModel::with(['question_category.categories', 'user','comment'])->where(array(
           ["baslik","like","%".$request->aranan."%"],
           ["status","=",1]
       ))->orderBy("id", "desc")->paginate(10);
       $aranan = $request->aranan;
       return view('front.search.index',compact('questions','aranan','banner'));
    }
}
