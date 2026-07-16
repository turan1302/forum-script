@extends('back.layout.master')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $item->name }} Kullanıcını Güncelle</h1>
    </div>

    <div class="row">
        <div class="col-lg-12">

            <!-- Basic Card Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $item->name }} Kullanıcısının Bilgileri</h6>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <form action="{{ route('back.uyeler.update',$item->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="">Kullanıcı Fotoğrafı</label>
                                    <br>
                                    @if($item->photo != "" && \Illuminate\Support\Facades\File::exists("storage/".$item->photo))
                                        <img src="{{ asset('storage/'.$item->photo) }}" width="150" height="150"
                                             alt="{{ $item->name }}">
                                    @else
                                        <img src="{{ asset('storage/resim-yok.webp') }}" width="150" height="150"
                                             alt="{{ $item->name }}">
                                    @endif
                                </div>

                                <div class="col-md-4 mt-3">
                                    <label for="">Nick</label>
                                    <input type="text" name="nickname" class="form-control"
                                           value="{{ old('nickname') ?? $item->nickname }}">
                                    @error('nickname')
                                    <small style="color: red;">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-4 mt-3">
                                    <label for="">Ad Soyad</label>
                                    <input type="text" name="name" class="form-control"
                                           value="{{ old('name') ?? $item->name }}">
                                    @error('name')
                                    <small style="color: red;">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-4 mt-3">
                                    <label for="">Doğum Tarihi</label>
                                    <input type="date" name="birthday" class="form-control"
                                           value="{{ old('birthday') ?? $item->birthday }}">
                                    @error('birthday')
                                    <small style="color: red;">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label for="">Telefon</label>
                                    <input type="text" name="phone" class="form-control"
                                           value="{{ old('phone') ?? $item->phone }}">
                                    @error('phone')
                                    <small style="color: red;">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label for="">E-Mail</label>
                                    <input type="text" name="email" class="form-control"
                                           value="{{ old('email') ?? $item->email }}">
                                    @error('email')
                                    <small style="color: red;">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label for="">Website (https:// olarak)</label>
                                    <input type="text" name="website" class="form-control"
                                           value="{{ old('website') ?? $item->website }}">
                                    @error('website')
                                    <small style="color: red;">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label for="">Meslek</label>
                                    <input type="text" name="meslek" class="form-control"
                                           value="{{ old('meslek') ?? $item->job }}">
                                    @error('meslek')
                                    <small style="color: red;">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-12 mt-3">
                                    <label for="">Hakkında</label>
                                    <textarea name="bio" class="form-control"
                                              rows="5">{{ old('bio') ?? $item->bio  }}</textarea>
                                    @error('bio')
                                    <small style="color: red;">{{ $message }}</small>
                                    @enderror
                                </div>

                                <hr>

                                <div class="col-md-12 mt-3">
                                    <label for="">Şifreniz</label>
                                    <input type="password" name="password" class="form-control"
                                           placeholder="Boş Bırakırsanız Değişmez">
                                    @error('password')
                                    <small style="color: red;">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-12 mt-3">
                                    <label for="">Şifre Tekrar</label>
                                    <input type="password" name="password_confirmation" class="form-control"
                                           placeholder="Boş Bırakırsanız Değişmez">
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-check"></i>
                                        Güncelle
                                    </button>

                                    <a href="{{ route('back.uyeler.index') }}" class="btn btn-danger btn-sm"><i
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
