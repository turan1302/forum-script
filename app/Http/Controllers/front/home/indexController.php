<?php

namespace App\Http\Controllers\front\home;

use App\Http\Controllers\Controller;
use App\Models\BannerModel;
use App\Models\QuestionsModel;
use App\Models\SettingsModel;
use App\Models\SosyalMedyaModel;
use App\Models\User;
use Illuminate\Http\Request;

class indexController extends Controller
{
    public function __construct()
    {
        if (SettingsModel::find(1)->site_durum == "0") {
            return redirect()->route('site-bakim')->send();
        }
    }

    public function index()
    {
        // BANNER MODULU
        $banner = BannerModel::where("banner_anahtar","anasayfa")->first();

        // SON SORULAR
        $questions = QuestionsModel::with(['question_category.categories', 'user', 'comment'])->where("status", 1)->orderBy("id", "desc")->paginate(10);
        return view('front.home.index', compact('questions','banner'));
    }

    // CEVAPLANMIS SORULAR
    public function cevaplanmis()
    {
        $banner = BannerModel::where("banner_anahtar","cevaplanmis")->first();

        $questions = QuestionsModel::with(['question_category.categories', 'user', 'comment'])->select("questions.*")->leftJoin("comments", "questions.id", "=", "comments.question_id")->where(array(
            "questions.status" => 1,
            "comments.status" => 1
        ))->orderBy("questions.id", "desc")->paginate(10);

        return view('front.home.cevaplanmis', compact('questions','banner'));
    }

    // ÇÖZÜMLENMİŞ SORULAR
    public function cozumlenmis(){

        $banner = BannerModel::where("banner_anahtar","cozumlenmis")->first();

        $questions = QuestionsModel::with(['question_category.categories', 'user', 'comment'])->select("questions.*")->leftJoin("comments", "questions.id", "=", "comments.question_id")->where(array(
            "questions.status" => 1,
            "comments.status" => 1,
            "comments.is_true" => 1
        ))->orderBy("questions.id", "desc")->paginate(10);

        return view('front.home.cozumlenmis', compact('questions','banner'));
    }

    // KULLANICI LISTESI
    public function user_list(){

        $banner = BannerModel::where("banner_anahtar","uyeler")->first();

        $items = User::where(array(
            "durum" => 1,
            "uyelik_onay" => 1,
            "isAdmin" => 0
        ))->orderBy("id","desc")->paginate(12);
        return view('front.home.users',compact('items','banner'));
    }

    // HAKKIMDA SAYFASI
    public function about(){
        return view('front.home.about');
    }

    // GİZLİLİK POLİTİKASI SAYFASI
    public function privacy(){
        return view('front.home.privacy');
    }

    // KVKK KAPSAMI
    public function kvkk(){
        return view('front.home.kvkk');
    }

    // SOSYAL MEDYA KISMI
    public function sosyal_medya($sm_anahtar=""){
        $sm = SosyalMedyaModel::where("sm_anahtar",$sm_anahtar)->firstOrFail();
        return redirect()->to($sm->sm_url);
    }
}
