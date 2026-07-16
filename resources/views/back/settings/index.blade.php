@extends('back.layout.master')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Ayarlar</h1>
    </div>

    <div class="row">
        <div class="col-lg-12">

            <!-- Basic Card Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Ayar Bilgileri</h6>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <form action="{{ route('back.settings.update',$item->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="">Site URL</label>
                                    <input class="form-control" name="site_url" type="text"
                                           value="{{ old('site_url') ?? $item->site_url }}">
                                    @error('site_url')
                                    <small style="color: red;">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label for="">Site Başlık</label>
                                    <input class="form-control" name="site_baslik" type="text"
                                           value="{{ old('site_baslik') ?? $item->site_baslik }}">
                                    @error('site_baslik')
                                    <small style="color: red;">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label for="">Site Açıklama</label>
                                    <input class="form-control" name="site_desc" type="text"
                                           value="{{ old('site_desc') ?? $item->site_desc }}">
                                    @error('site_desc')
                                    <small style="color: red;">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label for="">Site Keywords</label>
                                    <input class="form-control" name="site_keyw" type="text"
                                           value="{{ old('site_keyw') ?? $item->site_keyw }}">
                                    @error('site_keyw')
                                        <small style="color: red;">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-3 mt-3">
                                    <label for="">Site Harita</label>
                                    <input class="form-control" name="site_harita" type="text"
                                           value="{{ old('site_harita') ??  $item->site_harita }}">
                                    @error('site_harita')
                                    <small style="color: red;">{{ $message }}</small>
                                    @enderror
                                </div>


                                <div class="col-md-3 mt-3">
                                    <label for="">Site Harita Durum</label>
                                    <select name="site_harita_durum" class="form-control" id="">
                                        <option value="1" {{ ($item->site_harita_durum==1) ? 'selected' : '' }}>Aktif
                                        </option>
                                        <option value="0" {{ ($item->site_harita_durum==0) ? 'selected' : '' }}>Pasif
                                        </option>
                                        @error('site_harita_durum')
                                            <small style="color: red;">{{ $message }}</small>
                                        @enderror
                                    </select>
                                </div>

                                <div class="col-md-3 mt-3">
                                    <label for="">Site Mail</label>
                                    <input class="form-control" name="site_mail" type="text"
                                           value="{{ old('site_mail') ?? $item->site_mail }}">
                                    @error('site_mail')
                                        <small style="color: red;">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-3 mt-3">
                                    <label for="">Site Durum</label>
                                    <select name="site_durum" class="form-control">
                                        <option value="1" {{ ($item->site_durum==1) ? 'selected' : (((!empty(old('site_durum'))) && old('site_durum')==1) ? 'selected' : '') }}>Aktif</option>
                                        <option value="0" {{ ($item->site_durum==0) ? 'selected' : ((!empty(old('site_durum')) && old('site_durum')==0) ? 'selected' : '') }}>Pasif</option>
                                    </select>
                                    @error('site_durum')
                                        <small style="color: red;">{{ $message }}</small>
                                    @enderror
                                </div>

                                <hr>

                                <div class="col-md-6 mt-3">
                                    <label for="">Aktif İkon (Logo)</label>
                                    <br>
                                    @if($item->site_icon != "" && \Illuminate\Support\Facades\File::exists("storage/".$item->site_icon))
                                        <img width="100" height="100" src="{{ asset('storage/'.$item->site_icon) }}"
                                             alt="{{ $item->site_baslik }}">
                                    @else
                                        <img width="100" height="100" src="{{ asset('storage/resim-yok.webp') }}"
                                             alt="{{ $item->site_baslik }}">
                                    @endif
                                    <input type="file" name="site_icon" class="form-control mt-3">
                                    @error('site_icon')
                                        <small style="color: red;">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label for="">Aktif Favicon</label>
                                    <br>
                                    @if($item->site_favicon != "" && \Illuminate\Support\Facades\File::exists("storage/".$item->site_favicon))
                                        <img width="100" height="100" src="{{ asset('storage/'.$item->site_favicon) }}"
                                             alt="{{ $item->site_baslik }}">
                                    @else
                                        <img width="100" height="100" src="{{ asset('storage/resim-yok.webp') }}"
                                             alt="{{ $item->site_baslik }}">
                                    @endif
                                    <input type="file" name="site_favicon" class="form-control mt-3">
                                    @error('site_favicon')
                                    <small style="color: red;">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label for="">Google Doğrulama Kodu</label>
                                    <input type="text" class="form-control" name="google_dogrulama_kodu" value="{{ old('google_dogrulama_kodu') ?? $item->google_dogrulama_kodu }}">
                                    @error('google_dogrulama_kodu')
                                        <small style="color: red;">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label for="">Yandex Doğrulama Kodu</label>
                                    <input type="text" class="form-control" name="yandex_dogrulama_kodu" value="{{ old('yandex_dogrulama_kodu') ?? $item->yandex_dogrulama_kodu }}">
                                    @error('yandex_dogrulama_kodu')
                                    <small style="color: red;">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label for="">Bing Doğrulama Kodu</label>
                                    <input type="text" class="form-control" name="bing_dogrulama_kodu" value="{{ old('bing_dogrulama_kodu') ?? $item->bing_dogrulama_kodu }}">
                                    @error('bing_dogrulama_kodu')
                                    <small style="color: red;">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label for="">Google Analytcs Kodu</label>
                                    <input type="text" class="form-control" name="analiytcs_kodu" value="{{ old('analiytcs_kodu') ?? $item->analiytcs_kodu }}">
                                    @error('analiytcs_kodu')
                                    <small style="color: red;">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-check"></i>
                                        Güncelle
                                    </button>
                                    <a href="{{ route('back.home.index') }}" class="btn btn-danger btn-sm"><i
                                            class="fa fa-arrow-left"></i> Geriye Dön</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
