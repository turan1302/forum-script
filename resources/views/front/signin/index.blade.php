@extends('front.layout.master')
@section('title','Giriş Yap | '.$datalar['ayarlar']->site_baslik)
@section('description',$datalar['ayarlar']->site_desc)
@section('keywords',$datalar['ayarlar']->site_keyw)
@section('og_title','Giriş Yap | '.$datalar['ayarlar']->site_baslik)
@section('og_description',"Senin de bir seyyar yazılımcı hesabın varsa hemen giriş yap dostum")
@section('tw_title','Giriş Yap | '.$datalar['ayarlar']->site_baslik)
@section('tw_description',"Senin de bir seyyar yazılımcı hesabın varsa hemen giriş yap dostum")
@section('content')
    <div class="tt-loginpages-wrapper">
        <div class="tt-loginpages">
            <a href="javascript:void(0)" class="tt-block-title">
                <img src="{{ asset('storage/'.$datalar['ayarlar']->site_icon) }}" width="65" height="73" alt="{{ $datalar['ayarlar']->site_baslik }}">
                <div class="tt-title">
                    Seyyar'a Hoş Geldin Dostum
                </div>
                <div class="tt-description">
                    Anlaşılan bir sorun var onu soracaksın veya iyi niyetli sen bir başka Seyyar'a yardım edeceksin :).
                    Hemen giriş yapıver
                </div>
            </a>
            <form action="{{ route('front.signin.login') }}" class="form-default" method="POST">
                @csrf
                <div class="form-group">
                    <label for="loginUserName">E-Mail Adresiniz veya Kullanıcı Adınız</label>
                    <input type="text" name="name_or_email" class="form-control" id="loginUserName" placeholder="E-Mail Adresinizi Giriniz">
                    @error('name_or_email')
                        <small style="color: red;">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="loginUserPassword">Şifreniz</label>
                    <input type="password" name="password" class="form-control" id="loginUserPassword"
                           placeholder="Şifreniz">
                    @error('password')
                        <small style="color: red;">{{ $message }}</small>
                    @enderror
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <div class="checkbox-group">
                                <input type="checkbox" id="settingsCheckBox01" name="beni_hatirla">
                                <label for="settingsCheckBox01">
                                    <span class="check"></span>
                                    <span class="box"></span>
                                    <span class="tt-text">Beni Hatırla</span>
                                </label>
                            </div>
                        </div>
                    </div>
{{--                    <div class="col ml-auto text-right">--}}
{{--                        <a href="#" class="tt-underline">Şifreni Mi Unuttun ?</a>--}}
{{--                    </div>--}}
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-secondary btn-block">Giriş Yap</button>
                </div>
                <p>Aaa pardon demeyin unuttum. Hesabın yoksa <a href="{{ route('front.signup.index') }}" class="tt-underline">Buradan</a> Kayıt Olabilirsin</p>
                <div class="tt-notes">
                      Tüm Hakları Saklıdır &copy; {{ $datalar['ayarlar']->site_baslik }} <a href="{{ route('front.privacy') }}" target="_blank" class="tt-underline">Gizlilik Şartları</a> | <a
                        href="{{ route('front.kvkk') }}" target="_blank" class="tt-underline">KVKK Kapsamı</a>
                </div>
            </form>
        </div>
    </div>
@endsection

