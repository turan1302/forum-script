<?php

namespace App\Http\Controllers\front\signin;

use App\Http\Controllers\Controller;
use App\Http\Requests\front\LoginRequest;
use App\Models\SettingsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class indexController extends Controller
{
    public function __construct()
    {
        if (SettingsModel::find(1)->site_durum == "0") {
            return redirect()->route('site-bakim')->send();
        }
        $this->middleware('frontGuest')->except("logout");
    }

    public function index(){
        return view('front.signin.index');
    }

    // LOGIN OLMA KISMI
    public function login(LoginRequest $request){

        // EĞER EMAİL KISMI GERCEKTEN BIR EMAIL ISE
        if (filter_var($request->name_or_email,FILTER_VALIDATE_EMAIL)){
            $credentials = [
                "email" => $request->name_or_email,
                "password" => $request->password,
                "durum" => 1,
                "uyelik_onay" => 1
            ];
        }else{
            $credentials = [
                "nickname" => $request->name_or_email,
                "password" => $request->password,
                "durum" => 1,
                "uyelik_onay" => 1
            ];
        }


        if (Auth::attempt($credentials,$request->has('beni_hatirla'))){
            $request->session()->regenerate();
            return redirect()->route('front.index')->with(array(
                "type" => "success",
                "title" => "Hoşgeldin Seyyar: ",
                "message" => \auth()->user()->name
            ));
        }else{
            return redirect()->back()->with(array(
                "type" => "error",
                "title" => "Hata",
                "message" => "Giriş Bilgileriniz Hatalı ve/veya Üyeliğinizi Onaylamanız Gerekli"
            ));
        }
    }

    // LOGOUT KISMI
    public function logout(){
        \auth()->logout();
        \request()->session()->flush();
        \request()->session()->regenerate();

        $alert = [
            "type" => "success",
            "title" => "Başarılı",
            "message" => "Çıkış İşleminiz Başarılı"
        ];

        return redirect()->route('front.index')->with($alert);
    }
}
