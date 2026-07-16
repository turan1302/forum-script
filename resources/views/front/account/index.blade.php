@extends('front.layout.master')

@section('title','Hesabım | '.$datalar['ayarlar']->site_baslik)
@section('description',$datalar['ayarlar']->site_desc)
@section('keywords',$datalar['ayarlar']->site_keyw)

{{-- TWITTER OG ETIKETLERI --}}
@section('tw_title','Kategoriler | '.$datalar['ayarlar']->site_baslik)
@section('tw_description',"Sistemimizde yer alan kategoriler bu alanda yer alır")

@if(auth()->user()->photo != "" && \Illuminate\Support\Facades\File::exists("storage/".auth()->user()->photo))
    @section('tw_image',asset('storage/'.auth()->user()->photo))
@endif

@section('css')

@endsection

@section('content')

    <div class="container justify-content-center align-items-center" style="margin-top: 5%; width: 70%;">
        <div class="card">
            <div class="card-header">
                Hesap Ayarları
                @if(auth()->user()->dogru_yanit_sayisi >= 50)
                    <i class="fas fa-check-circle text-success"></i>
                @endif
            </div>
            <div class="card-body">
                <div class="form-group">
                    <form action="{{ route('front.hesabim.info_update',auth()->user()->id) }}" method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="row">
                            <div class="col-md-6">
                                <label>Aktif Fotoğraf</label>
                                <br>
                                @if(auth()->user()->photo != "" && \Illuminate\Support\Facades\File::exists("storage/".auth()->user()->photo))
                                    <img src="{{ asset('storage/'.auth()->user()->photo) }}" width="100" height="100"
                                         alt="{{ auth()->user()->name }}">
                                @else
                                    <img src="{{ asset('storage/resim-yok.webp') }}" width="100" height="100" alt="">
                                @endif
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <label for="">Fotoğraf Seç</label>
                                <input type="file" name="photo" class="form-control">
                                @error('photo')
                                <small style="color: red;">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <label>Kullanıcı Adınız</label>
                                <input type="text" disabled class="form-control" value="{{ auth()->user()->nickname }}">
                            </div>
                            <div class="col-md-4">
                                <label>Adınız Soyadınız</label>
                                <input type="text" name="name" class="form-control"
                                       value="{{ old('name') ?? auth()->user()->name }}">
                                @error('name')
                                <small style="color: red;"> {{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label>E-Mail Adresiniz</label>
                                <input type="text" name="email" class="form-control"
                                       value="{{ old('email') ?? auth()->user()->email }}">
                                @error('email')
                                <small style="color: red;"> {{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-3">
                                <label for="">Telefon Numaranız</label>
                                <input type="text" name="phone" class="form-control"
                                       value="{{ old('phone') ??  auth()->user()->phone }}">
                                @error('phone')
                                <small style="color: red;">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label for="">Website (https:// olarak)</label>
                                <input type="text" name="website" class="form-control"
                                       value="{{ old('website') ??  auth()->user()->website }}">
                                @error('website')
                                <small style="color: red;">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label for="">Mesleğiniz</label>
                                <input type="text" name="job" class="form-control"
                                       value="{{ old('job') ??  auth()->user()->job }}">
                                @error('job')
                                <small style="color: red;">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label>Doğum Tarihiniz</label>
                                <input type="date" class="form-control" name="birthday"
                                       value="{{ old('birthday') ?? auth()->user()->birthday }}">
                                @error('birthday')
                                <small style="color: red;">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <label for="">E-Mail Gizle</label>
                                <select name="email_gizle" class="form-control">
                                    <option
                                        value="1" {{ (!empty(old('email_gizle')) && old('email_gizle')==1) ? 'selected' : ((auth()->user()->email_gizle==1) ? 'selected' : '') }}>
                                        Aktif
                                    </option>
                                    <option
                                        value="0" {{ (!empty(old('email_gizle')) && old('email_gizle')==0) ? 'selected' : ((auth()->user()->email_gizle==0) ? 'selected' : '') }}>
                                        Pasif
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="">Telefon Gizle</label>
                                <select name="telefon_gizle" class="form-control">
                                    <option
                                        value="1" {{ (!empty(old('telefon_gizle')) && old('telefon_gizle')==1) ? 'selected' : ((auth()->user()->telefon_gizle==1) ? 'selected' : '') }}>
                                        Aktif
                                    </option>
                                    <option
                                        value="0" {{ (!empty(old('telefon_gizle')) && old('telefon_gizle')==0) ? 'selected' : ((auth()->user()->telefon_gizle==0) ? 'selected' : '') }}>
                                        Pasif
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="">Profil Foto Gizle</label>
                                <select name="profil_foto_gizle" class="form-control">
                                    <option
                                        value="1" {{ (!empty(old('profil_foto_gizle')) && old('profil_foto_gizle')==1) ? 'selected' : ((auth()->user()->profil_foto_gizle==1) ? 'selected' : '') }}>
                                        Aktif
                                    </option>
                                    <option
                                        value="0" {{ (!empty(old('profil_foto_gizle')) && old('profil_foto_gizle')==0) ? 'selected' : ((auth()->user()->profil_foto_gizle==0) ? 'selected' : '') }}>
                                        Pasif
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <label for="">Hakkında</label>
                            <div class="col-md-12">
                                <textarea name="bio" class="form-control"
                                          rows="5">{{ old('bio') ?? auth()->user()->bio }}</textarea>
                            </div>
                        </div>
                        <hr>
                        <h6>Şifre Değiştir</h6>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <label for="">Mevcut Şifreniz</label>
                                <input type="password" name="current_password" class="form-control">
                            </div>
                            <div class="col-md-12 mt-2">
                                <label for="">Yeni Şifreniz</label>
                                <input type="password" name="password" class="form-control">
                                @error('password')
                                <small style="color: red;">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-12 mt-2">
                                <label for="">Yeni Şifre Tekrarı</label>
                                <input type="password" name="password_confirmation" class="form-control">
                            </div>
                        </div>
                        <hr>
                        <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-check-circle"></i> Güncelle
                        </button>
                        <a href="{{ route('front.index') }}" class="btn btn-danger btn-sm"><i
                                class="fa fa-times-circle"></i> Vazgeç</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
