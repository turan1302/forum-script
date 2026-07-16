@extends('back.layout.master')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Yorum Görüntüleme</h1>
    </div>

    <div class="row">
        <div class="col-lg-12">

            <!-- Basic Card Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Yorum Bilgileri</h6>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="">Yorum Atan Kişi</label>
                                <input class="form-control" readonly type="text" value="{{ optional($item->user)->name }}">
                            </div>

                            <div class="col-md-12 mt-3">
                                <label for="">IP Adresi</label>
                                <input type="text" readonly class="form-control" value="{{ $item->ip_address }}">
                            </div>

                            <div class="col-md-12 mt-3">
                                <label for="">Hangi Soruya Yazdı</label>
                                <input type="text" readonly name="baslik" class="form-control"
                                       value="{{ optional($item->question)->baslik }}">
                            </div>

                            <div class="col-md-12 mt-3">
                                <label for="">Yorum Açıklaması</label>
                                <textarea readonly name="text" class="editor" rows="5">{{ $item->comment  }}</textarea>
                            </div>

                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <a href="{{ route('back.comments.index') }}" class="btn btn-danger btn-sm"><i
                                        class="fa fa-arrow-left"></i> Geriye Dön</a>
                            </div>
                        </div>
                    </div>
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
            readonly : 1,
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
