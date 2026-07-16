<?php

namespace App\Http\Controllers\back\login;

use App\Http\Controllers\Controller;
use App\Http\Requests\back\AdminRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class indexController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except("logout");
    }

    public function index()
    {
        return view('back.login.index');
    }

    public function do_login(AdminRequest $request)
    {
        $credentials = [
            "email" => $request->email,
            "password" => $request->password,
            "durum" => 1,
            "uyelik_onay" => 1,
            "isAdmin" => 1
        ];

        if (Auth::attempt($credentials, $request->has('beni_hatirla'))) {
            $request->session()->regenerate();

            $alert = [
                "type" => "success",
                "title" => "Başarılı",
                "message" => "Hoşgeldiniz Admin: " . \auth()->user()->name
            ];
        } else {
            $alert = [
                "type" => "error",
                "title" => "Hata",
                "message" => "Giriş Yapılırken Hata Oluştu. Lütfen Daha Sonra Tekrar Deneyiniz"
            ];
        }

        return redirect()->route('back.home.index')->with($alert);
    }

    public function logout(Request $request)
    {
        auth::logout();
        $request->session()->flush();
        $request->session()->regenerate();

        $alert = [
            "type" => "success",
            "title" => "Başarılı",
            "message" => "Çıkış yapma işlemi başarılı"
        ];

        return redirect()->route('back.login.index')->with($alert);
    }
}
