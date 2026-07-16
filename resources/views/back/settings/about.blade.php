@extends('back.layout.master')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Hakkımda</h1>
    </div>

    <div class="row">
        <div class="col-lg-12">

            <!-- Basic Card Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Hakkımda Bilgileri</h6>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <form action="{{ route('back.settings.about_update',$item->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="">Site Hakkında</label>
                                    <textarea class="editor" name="site_hakkinda" rows="5">{{ old('site_hakkinda') ?? $item->site_hakkinda }}</textarea>
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
