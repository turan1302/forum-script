@extends('back.layout.master')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Sosyal Medya Ekleme</h1>
    </div>

    <div class="row">
        <div class="col-lg-12">

            <!-- Basic Card Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Sosyal Medya Bilgileri</h6>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <form action="{{ route('back.sm.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="">Sosyal Medya Anahtar</label>
                                    <input type="text" name="sm_anahtar" placeholder="örn: facebook " class="form-control" value="{{ old('sm_anahtar') ?? '' }}">
                                    @error('sm_anahtar')
                                        <small style="color: red;">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label for="">Sosyal Medya Başlık</label>
                                    <input type="text" name="sm_baslik" class="form-control" placeholder="Sosyal Medya İsmini Giriniz" value="{{ old('sm_baslik') ?? '' }}">
                                    @error('sm_baslik')
                                        <small style="color: red;">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label for="">Sosyal Medya İkon</label>
                                    <input type="text" name="sm_icon" class="form-control" placeholder="Sosyal Medya İkonu (font awesome)" value="{{ old('sm_icon') ?? '' }}">
                                    @error('sm_icon')
                                        <small style="color: red;">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label for="">Sosyal Medya Url</label>
                                    <input type="text" name="sm_url" class="form-control" placeholder="Sosyal Medya Url (https:// olarak)" value="{{ old('sm_url') ?? '' }}">
                                    @error('sm_url')
                                    <small style="color: red;">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-success btn-sm"><i
                                            class="fa fa-check-circle"></i> Ekle
                                    </button>
                                    <a href="{{ route('back.sm.index') }}" class="btn btn-danger btn-sm"><i
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
