@extends('front.layout.master')

@section('title','Kayıt Ol | '.$datalar['ayarlar']->site_baslik)
@section('description',$datalar['ayarlar']->site_desc)
@section('keywords',$datalar['ayarlar']->site_keyw)

{{-- OG ETIKETLERI --}}
@section('og_title','Kayıt Ol | '.$datalar['ayarlar']->site_baslik)
@section('og_description',"Sen de aklında olan soruları seyyar yazılımcılara sormak ve/veya sorusu olan seyyar yazılımcılara yardım etmek istiyorsan hemen üye olabilirsin dostum")

{{-- TWITTER OG ETIKETLERI --}}
@section('tw_title','Kayıt Ol | '.$datalar['ayarlar']->site_baslik)
@section('tw_description',"Sen de aklında olan soruları seyyar yazılımcılara sormak ve/veya sorusu olan seyyar yazılımcılara yardım etmek istiyorsan hemen üye olabilirsin dostum")

@section('content')
    <div class="tt-loginpages-wrapper">
        <div class="tt-loginpages">
            <a href="javascript:void(0)" class="tt-block-title">
                <img src="{{ asset('storage/'.$datalar['ayarlar']->site_icon) }}" alt="{{ $datalar['ayarlar']->site_baslik }}">
                <div class="tt-title">
                    Seyyar'a Sormak İçin Kayıt Ol Dostum :)
                </div>
                <div class="tt-description">
                    Anlaşılan senin de seyyar yazılımcılara danışmak istediğin konu var. O halde hemen kayıt ol :)
                </div>
            </a>
            <form action="{{ route('front.signup.store') }}" method="POST" class="form-default">
                @csrf
                <div class="form-group">
                    <label for="loginUserName">Adınız Soyadınız</label>
                    <input type="text" name="name" class="form-control" placeholder="Adınız Soyadınız"
                           value="{{ old('name') ?? '' }}">
                    @error('name')
                    <small style="color: red;">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="loginUserName">Doğum Tarihiniz</label>
                    <input type="date" name="birthday" class="form-control" placeholder="Doğum Tarihiniz"
                           value="{{ old('birthday') ?? '' }}">
                    @error('birthday')
                    <small style="color: red;">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="loginUserEmail">E-Mail Adresiniz</label>
                    <input type="text" name="email" class="form-control"
                           placeholder="E-Mail Adresiniz" value="{{ old('email') ?? '' }}">
                    @error('email')
                    <small style="color: red;">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="loginUserEmail">E-Mail Tekrar (Aktivasyon İçin)</label>
                    <input type="text" name="email_confirmation" class="form-control"
                           placeholder="E-Mail Tekrar" value="">
                </div>
                <div class="form-group">
                    <label for="loginUserPassword">Şifreniz</label>
                    <input type="password" name="password" class="form-control"
                           placeholder="Şifreniz">
                    @error('password')
                    <small style="color: red;">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="loginUserPassword">Şifre Tekrar</label>
                    <input type="password" name="password_confirmation" class="form-control"
                           placeholder="Şifre Tekrar">
                </div>
                <div class="form-group">
                    <input type="checkbox" required>
                    <label for="settingsCheckBox01">
                        <span class="check"></span>
                        <span class="box"></span>
                        <span class="tt-text">KVKK Kapsamını Okudum, Onaylıyorum</span>
                    </label>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-secondary btn-block">Kayıt Ol</button>
                </div>
                <p>Aaa pardon :) Hesabın var ise <a href="{{ route('front.signin.index') }}" class="tt-underline">Buradan</a>
                    giriş yapabilirsin</p>
                <div class="tt-notes">
                    Tüm Hakları Saklıdır &copy; {{ $datalar['ayarlar']->site_baslik }} <a
                        href="{{ route('front.privacy') }}" target="_blank" class="tt-underline">Gizlilik Şartları</a> |
                    <a
                        href="{{ route('front.kvkk') }}" target="_blank" class="tt-underline">KVKK Kapsamı</a>
                </div>
            </form>
        </div>
    </div>
@endsection

