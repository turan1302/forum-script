@extends('front.layout.master')

@section('title',$item->baslik.' Sorusunu Güncelle | '.$datalar['ayarlar']->site_baslik)
@section('description',$datalar['ayarlar']->site_desc)
@section('keywords',$datalar['ayarlar']->site_keyw)

{{-- OG ETIKETLERI --}}
@section('og_type',$item->baslik." Sorusunu Güncelle")
@section('og_title',$item->baslik)
@section('og_description',\Illuminate\Support\Str::words($item->text,20))

{{-- TWITTER OG ETIKETLERI --}}
@section('tw_title',$item->baslik.'Sorusunu Güncelle | '.$datalar['ayarlar']->site_baslik)
@section('tw_description',\Illuminate\Support\Str::words($item->text,20))

@if($item->user->photo != "" && \Illuminate\Support\Facades\File::exists("storage/".$item->user->photo))
    @section('tw_image',asset('storage/'.$item->user->photo))
@endif

@section('content')

    @include('front.layout.banner')

    <div class="tt-wrapper-inner mt-4">
        <h1 class="tt-title-border">
            Sorumu Düzenlemek İstiyorum
        </h1>
        <form action="{{ route('front.question.update_question',$item->id) }}" class="form-default form-create-topic" method="POST">
            @csrf
            @method('PATCH')
            <div class="form-group">
                <label for="inputTopicTitle">Soru Başlığı</label>
                <div class="tt-value-wrapper">
                    <input type="text" name="baslik" class="form-control" id="inputTopicTitle"
                           placeholder="Soru başlığını bu kısımdan seçiniz" value="{{ old('baslik') ?? $item->baslik }}">
                    @error('baslik')
                    <small style="color: red;">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="form-group mt-5">
                <label>Kategori Seçimi</label>
                <div class="row text-center">
                    @forelse($categories as $k => $v)
                        <div class="col-md-3" style="padding: 5px;">
                            <input type="checkbox" name="categories[]" {{ (!empty(old('categories')) && in_array($v->id,old('categories'))) ? 'checked' : ((!empty($item->question_category()->where("category_id",$v->id)->first())) ? 'checked' : '') }} value="{{ $v->id }}"
                                   multiple>{{ $v->kat_adi }}
                        </div>
                    @empty
                    @endforelse
                </div>

                @error('categories')
                <small style="color: red;">{{ $message }}</small>
                @enderror
            </div>
            <div class="pt-editor">
                <h6 class="pt-title">Sorunuz</h6>
                <br>
                <p>
                    <b>Yazma Kuralları</b>
                <ul>
                    <li>Resim Eklemek <a href="https://www.hizliresim.com/" target="_blank">Hızlı Resim</a> Sitesindeki Linki Yerleştirin</li>
                    <li>Kod Eklemek İçin Tinymce Kod Editörünü Kullanınız</li>
                    <li>Argo, Siyasi ve Hakaret İçerikler Kullanmayınız</li>
                </ul>
                </p>
                <div class="form-group">
                    <textarea name="text" class="editor">{{ old('text') ?? $item->text }}</textarea>
                    @error('text')
                    <small style="color: red;">{{ $message }}</small>
                    @enderror
                </div>
                {{-- ETİKETLER KISMI AYARLAMA ISLEMINI YAPALIM --}}
                <div class="form-group">
                    <label for="">Etiketler (İsterseniz Sorunuza Etiket Girebilirsiniz)</label>
                    <input type="text" class="form-control" placeholder="Etiketleri virgüle ayırınız" name="tags" value="{{ old('tags') ?? $item->tags }}">
                    <small style="color: red;">Konunuz ile ilgili etiket yazmanız sorunuzu bir adım öne çıkaracaktır</small>
                </div>
                <div class="row">
                    <div class="col-auto ml-md-auto">
                        <button type="submit" class="btn btn-success btn-width-lg">Sorunu Güncelle</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('content2')
    <a href="{{ route('front.question.index') }}" class="tt-btn-create-topic">
    <span class="tt-icon">
        <svg>
          <use xlink:href="#icon-create_new"></use>
        </svg>
    </span>
    </a>
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
