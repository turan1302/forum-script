@extends('back.layout.master')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Profil Sayfanız</h1>
    </div>

    <div class="row">
        <div class="col-lg-12">

            <!-- Basic Card Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Profil Bilgileri</h6>
                </div>
                <div class="card-body">
                    <form action=" {{ route('back.profile.update',auth()->user()->id) }}" method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="">Aktif Fotoğraf</label>
                                    <br>
                                    @if(auth()->user()->photo != "" && \Illuminate\Support\Facades\File::exists("storage/".auth()->user()->photo))
                                        <img src="{{ asset('storage/'.auth()->user()->photo) }}" width="100"
                                             height="100" alt="{{ auth()->user()->name }}">
                                    @else
                                        <img src="{{ asset('storage/resim-yok.webp') }}" width="100" height="100"
                                             alt="{{ auth()->user()->name }}">
                                    @endif
                                    <input type="file" name="photo" class="form-control mt-3">
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <label for="">Kullanıcı Adınız</label>
                                    <input type="text" class="form-control" name="nickname"
                                           value="{{ old('nickname') ??  auth()->user()->nickname }}">
                                    @error('nickname')
                                    <small style="color: red;">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="">Adınız Soyadınız</label>
                                    <input type="text" class="form-control" name="name"
                                           value="{{ old('name') ??  auth()->user()->name }}">
                                    @error('name')
                                    <small style="color: red;">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="">E-Mail Adresiniz</label>
                                    <input type="text" class="form-control" name="email"  value="{{ old('email') ??  auth()->user()->email }}">
                                    @error('email')
                                    <small style="color: red;">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-3">
                                    <label for="">Telefon Numaranız</label>
                                    <input type="text" class="form-control" name="phone" value="{{ old('phone') ??  auth()->user()->phone }}">
                                    @error('phone')
                                    <small style="color: red;">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label for="">Web Siteniz (https:// olarak)</label>
                                    <input type="text" class="form-control" name="website" value="{{ old('website') ??  auth()->user()->website }}">
                                    @error('website')
                                    <small style="color: red;">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label for="">Mesleğiniz</label>
                                    <input type="text" class="form-control" name="job" value="{{ old('job') ??  auth()->user()->job }}">
                                    @error('job')
                                    <small style="color: red;">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label for="">Doğum Tarihiniz</label>
                                    <input type="date" class="form-control" name="birthday" value="{{ old('birthday') ??  auth()->user()->birthday }}">
                                    @error('birthday')
                                    <small style="color: red;">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <textarea name="bio" class="editor" id="" cols="30" rows="10">{{ old('bio') ??  auth()->user()->bio }}</textarea>
                                    @error('bio')
                                    <small style="color: red;">{{ $message }}</small>
                                    @enderror
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

                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-check"></i>
                                        Güncelle
                                    </button>
                                    <a href="{{ route('back.home.index') }}" class="btn btn-danger btn-sm"><i
                                            class="fa fa-arrow-left"></i> Geriye Dön</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('js')
    <!-- TINYMCE -->
    <script src="{{ asset('front') }}/tinymce/jquery.min.js"></script>
    <script src="{{ asset('front') }}/tinymce/tinymce.js"></script>
    <script>
        tinymce.init({
            selector: "textarea.editor",
            width: "100%",
            height: 300,
            plugins: ["advlist codesample link image charmap print preview hr anchor pagebreak",
                "searchreplace visualblocks visualchars code insertdatetime media nonbreaking",
                "save table directionality emoticons template paste wordcount"],
            language: "tr_TR",
            toolbar: "insertfile code | undo redo | styleselect | bold italic underline | forecolor backcolor | alignleft aligncenter alignright alignjustify | " +
                " link unlink anchor | image | codesample fullpage"
        })

    </script>
@endsection
