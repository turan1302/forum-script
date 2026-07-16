<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\KategoriModel;
use App\Models\QuestionsModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class indexController extends Controller
{
    public function sitemap()
    {
        // YAZILARIN ALINMA ISLEMINI GERCEKLESTIRELIM
        $questions = QuestionsModel::where("status", 1)->orderBy("id", "desc")->get();
        $sonuc = view('api.sitemap', compact('questions'))->render();
        if (File::exists("sitemap.xml")){
            File::delete("sitemap.xml");
        }
        File::put("sitemap.xml",$sonuc);
        return response()->view('api.sitemap', compact('questions'))->header('Content-Type', 'text/xml');
    }

    // KATEGORILER KISMI AYARLAMASI
    public function kategoriler()
    {
        $categories = KategoriModel::where(array(
            "durum" => 1
        ))->orderBy("id", "desc")->get();

        $sonuc = view("api.sitemap_category", compact('categories'))->render();
        if (File::exists("kategoriler.xml")){
            File::delete("kategoriler.xml");
        }
        File::put("kategoriler.xml",$sonuc);
        return response()->view("api.sitemap_category", compact('categories'))->header('Content-Type', 'text/xml');
    }

    // ETIKET AYARLAMA ISLEMLERINI DEGISTIRELIM
    public function etiketler()
    {
        $etiket_bulutu = QuestionsModel::where(function ($c) {
            $c->where('status', 1);
        })->orderByDesc('id')->get();

        $etiket_bulut = "";
        foreach ($etiket_bulutu as $etiket) {
            if ($etiket->tags_slug) {
                $etiket_bulut .= $etiket->tags_slug . ",";
            }
        }

        $etiket_bulut = substr($etiket_bulut, 0, -1);  // SON KARAKTERİ (,) SİLDİK
        $etiket_bulut = explode(",", $etiket_bulut);  // GELEN VİRGÜLLÜLERİ PARÇALAYP DİZİYE AKTARDIK
        $etiket_bulut = (array_unique($etiket_bulut)); // UNİQUE OLARKA EKRANA BASTIRACAĞIZ

        $sonuc = view('api.sitemap_tags', compact('etiket_bulut'))->render();
        if (File::exists("etiketler.xml")){
            File::delete("etiketler.xml");
        }
        File::put("etiketler.xml",$sonuc);
        return response()->view('api.sitemap_tags', compact('etiket_bulut'))->header('Content-Type', 'text/xml');
    }

    // UYELER KISMI SITEMAP
    public function uyeler()
    {
        $users = User::where(array(
            "durum" => 1,
            "uyelik_onay" => 1,
            "isAdmin" => 0
        ))->orderBy("id", "desc")->get();

        $sonuc = view('api.sitemap_members', compact('users'))->render();
        if (File::exists("uyeler.xml")){
            File::delete("uyeler.xml");
        }
        File::put("uyeler.xml",$sonuc);
        return response()->view('api.sitemap_members', compact('users'))->header('Content-Type', 'text/xml');
    }
}
