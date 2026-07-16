@extends('back.layout.master')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Kategori Ekleme</h1>
    </div>

    <div class="row">
        <div class="col-lg-12">

            <!-- Basic Card Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Kategori Bilgileri</h6>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <form action="{{ route('back.categories.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="">Kategori Adı</label>
                                    <input type="text" name="kat_adi" class="form-control" value="{{ old('kat_adi') ?? '' }}">
                                    @error('kat_adi')
                                        <small style="color: red;">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="">Kategori Açıklama</label>
                                    <input type="text" name="kat_desc" class="form-control" value="{{ old('kat_desc') ?? '' }}">
                                    @error('kat_desc')
                                        <small style="color: red;">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="">Kategori Anahtar Kelimeler</label>
                                    <input type="text" name="kat_keyw" class="form-control" value="{{ old('kat_keyw') ?? '' }}">
                                    @error('kat_keyw')
                                        <small style="color: red;">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-4 mt-3">
                                    <label for="">Kategori Resim</label>
                                    <input type="file" name="kat_photo" class="form-control">
                                    @error('kat_photo')
                                    <small style="color: red;">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-success btn-sm"><i
                                            class="fa fa-check-circle"></i> Ekle
                                    </button>
                                    <a href="{{ route('back.categories.index') }}" class="btn btn-danger btn-sm"><i
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
