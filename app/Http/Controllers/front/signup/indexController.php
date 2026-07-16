<?php

namespace App\Http\Controllers\front\signup;

use App\Http\Controllers\Controller;
use App\Http\Requests\front\KayitRequest;
use App\Mail\UyelikAktiflestirmeMail;
use App\Models\SettingsModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class indexController extends Controller
{
    public function __construct()
    {
        if (SettingsModel::find(1)->site_durum == "0") {
            return redirect()->route('site-bakim')->send();
        }
        $this->middleware('frontGuest');
    }


    public function index()
    {
        return view('front.signup.index');
    }

    // KAYIT OLMA KISMI
    public function store(KayitRequest $request)
    {
        $data = $request->except("_token");
        $data['password'] = Hash::make($request->password);
        $data['aktiflestirme_kod'] = Str::random(10); // 10 HANELI AKTIFLESTIRME KODU GONDERELIM
        $sonuc = User::create($data);

        if ($sonuc) {
            Mail::to($sonuc->email)->send(new UyelikAktiflestirmeMail($sonuc));

            return redirect()->route('front.signin.login')->with(array(
                "type" => "success",
                "title" => "Başarılı",
                "message" => "Kayıt İşleminiz Başarıyla Gerçekleştirildi. Mail adresinize gönderilen linkten üyeliğinizi onaylayıp giriş yapabilirsiniz"
            ));
        } else {
            return redirect()->back()->with(array(
                "type" => "success",
                "title" => "Hata",
                "message" => "Kayıt İşleminde Bir Hata Oluştu. Lütfen daha sonra tekra deneyiniz"
            ));
        }
    }

    // UYELIK AKTIVASYON
    public function activation(User $item, $code)
    {
        $kod_sorgula = User::where("aktiflestirme_kod", $code)->firstOrFail();
        $sonuc = $item->update(array(
            "aktiflestirme_kod" => "",
            "uyelik_onay" => 1
        ));

        if ($sonuc) {
            $alert = [
                "type" => "success",
                "title" => "Başarılı",
                "message" => "Üyeliğiniz Başarıyla Aktifleştirildi"
            ];
        } else {
            $alert = [
                "type" => "error",
                "title" => "Hata",
                "message" => "Üyeliğiniz Aktifleştirilirken Hata Oluştu"
            ];
        }

        return redirect()->route('front.signin.index')->with($alert);
    }
}
