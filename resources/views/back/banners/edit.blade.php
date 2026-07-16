@extends('back.layout.master')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Banner Güncelleme</h1>
    </div>

    <div class="row">
        <div class="col-lg-12">

            <!-- Basic Card Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Banner Bilgileri</h6>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <form action="{{ route('back.banners.update',$item->id) }}" method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="">Banner Anahtar</label>
                                    <input type="text" name="banner_anahtar" class="form-control"
                                           value="{{ old('banner_anahtar') ?? $item->banner_anahtar }}">
                                    @error('banner_anahtar')
                                    <small style="color: red;">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="">Banner Başlık</label>
                                    <input type="text" class="form-control" name="banner_baslik"
                                           value="{{ old('banner_baslik') ?? $item->banner_baslik }}">
                                    @error('banner_baslik')
                                    <small style="color: red;">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label for="">Banner Açıklama</label>
                                    <textarea name="banner_aciklama" class="form-control"
                                              rows="5">{{ old('banner_aciklama') ?? $item->banner_aciklama }}</textarea>
                                    @error('banner_aciklama')
                                    <small style="color: red;">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label for="">Aktif Fotoğraf</label>
                                    <br>
                                    @if($item->banner_foto!="" && \Illuminate\Support\Facades\File::exists("storage/".$item->banner_foto))
                                        <img src="{{ asset('storage/'.$item->banner_foto) }}" width="100" height="100" alt="{{ $item->banner_baslik }}">
                                    @else
                                        <img src="{{ asset('storage/resim-yok.webp') }}" width="100" height="100" alt="{{ $item->banner_baslik }}">
                                    @endif
                                </div>
                                <div class="col-md-4 mt-3">
                                    <label for="">Banner Resim</label>
                                    <input type="file" name="banner_foto" class="form-control">
                                    @error('banner_foto')
                                    <small style="color: red;">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>


                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-success btn-sm"><i
                                            class="fa fa-check-circle"></i> Güncelle
                                    </button>
                                    <a href="{{ route('back.banners.index') }}" class="btn btn-danger btn-sm"><i
                                            class="fa fa-arrow-left"></i> Vazgeç</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
