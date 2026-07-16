@extends('front.layout.master')

@section('title',$item->baslik.' | '.$datalar['ayarlar']->site_baslik)
@section('description',$datalar['ayarlar']->site_desc)
@section('keywords',$datalar['ayarlar']->site_keyw)

{{-- OG ETIKETLERI --}}
@section('og_type',$item->user->name)
@section('og_title',$item->baslik)
@section('og_description',\Illuminate\Support\Str::words($item->text,20))

{{-- TWITTER OG ETIKETLERI --}}
@section('tw_title',$item->baslik.' | '.$datalar['ayarlar']->site_baslik)
@section('tw_description',\Illuminate\Support\Str::words($item->text,20))

@if($item->user->photo != "" && \Illuminate\Support\Facades\File::exists("storage/".$item->user->photo))
    @section('tw_image',asset('storage/'.$item->user->photo))
@endif

{{-- SCROLL KODU İÇİNDE --}}
@section('css')
    <link rel="stylesheet"
          href="{{asset('front')}}/highlight/css/ocean.css">
    <script src="{{asset('front')}}/highlight/js/highlight.pack.js"></script>
    <script>hljs.initHighlightingOnLoad();</script>


    <style type="text/css" media="screen">
        pre code {
            overflow-x: scroll;
            overflow-y: scroll;
            display: block;
            white-space: pre;
            max-height: 400px;
        }


        /** beğenme beğenmeme tuşu rengini ayarlayalım **/
        .isLike {
            color: white !important;
            background-color: #0E9A00 !important;
        }

        .isDissLike {
            color: white !important;
            background-color: #7c2000 !important;
        }
    </style>

    <style>
        /** DISSLIKE BUTONU KONUMLANDIRMA **/
        /** MASAUSTU **/
        @media screen and (min-width: 961px) {
            .commentDisslike, .questionDisslike {
                margin-left: 1%;
            }

            /** SILME KISMI **/
            .commentDelete {
                position: absolute;
                margin-top: -4%;
                margin-left: 83%;
            }
        }

        /** MOBİL **/
        @media screen and (max-width: 961px) {
            .commentDisslike, .questionDisslike {
                position: absolute;
                margin-left: 23%;
            }

            .commentDelete {
                position: absolute;
                margin-top: -7%;
                margin-left: 85%;
            }
        }
    </style>

    <link rel="stylesheet" href="{{ asset('front/detail/style.css') }}">
@endsection

@section('content')

    <div class="row gutters-sm">

        <!-- SORU DETAYLARI -->
    @include('front.question.soru_detail')

    <!-- SEYYAR IN DETAYI -->
        @include('front.question.seyyar_detail')

        <div class="tt-topic-list tt-ofset-30 mt-5">
            <div class="tt-list-search">
                <div class="tt-title"><b>Benzer Sorular</b></div>
            </div>
            <div class="tt-list-header tt-border-bottom">
                <div class="tt-col-topic">Seyyar'ın Sorusu</div>
                <div class="tt-col-category">Kategori</div>
                <div class="tt-col-value hide-mobile">Kim Sordu</div>
                <div class="tt-col-value hide-mobile text-center">Yanıtlanma</div>
                <div class="tt-col-value hide-mobile text-center">İzlenme</div>
                <div class="tt-col-value text-center">Zaman</div>
            </div>

            @php
                $sayac = 0;
            @endphp
            @forelse($benzer_sorular as $son_soru)
                <div class="tt-item tt-itemselect">
                    <div class="tt-col-avatar">
                        @if($son_soru->user->photo != "" && \Illuminate\Support\Facades\File::exists("storage/".$son_soru->user->photo) && $son_soru->user->profil_foto_gizle==0)
                            <img src="{{ asset('storage/'.$son_soru->user->photo) }}" width="50" height="50"
                                 alt="{{ $son_soru->baslik }}" style="border-radius: 30px">
                        @else
                            <img src="{{ asset('storage/resim-yok.webp') }}" width="50" height="50"
                                 alt="{{ $son_soru->baslik }}" style="border-radius: 30px;">
                        @endif
                    </div>
                    <div class="tt-col-description">
                        <h6 class="tt-title">
                            <a href="{{ route('front.question.question_detail',$son_soru->seflink) }}">
                                <svg class="tt-icon">
                                    <use xlink:href="#icon-pinned"></use>
                                </svg>
                                {{ \Illuminate\Support\Str::words($son_soru->baslik,10,"...") }}
                            </a></h6>
                        <div class="row align-items-center no-gutters">
                            <div class="col-11">
                                <ul class="tt-list-badge">
                                    @forelse($son_soru->question_category as $kategori)
                                        <li class="show-mobile"><a
                                                href="{{ route('front.category.category_detail',optional($kategori->categories)->kat_slug) }}"><span
                                                    class="tt-color01 tt-badge">{{ optional($kategori->categories)->kat_adi }}</span></a>
                                        </li>
                                    @empty
                                    @endforelse
                                </ul>
                            </div>
                            <div class="col-1 ml-auto show-mobile">
                                <div class="tt-value">1h</div>
                            </div>
                        </div>
                    </div>
                    <div class="tt-col-category">
                        @forelse($son_soru->question_category as $kategori)
                            <a href="{{ route('front.category.category_detail',optional($kategori->categories)->kat_slug) }}">
                                    <span
                                        class="tt-color01 tt-badge mt-2">{{ optional($kategori->categories)->kat_adi }}</span>
                            </a>
                        @empty
                        @endforelse
                    </div>
                    <div class="tt-col-value hide-mobile text-center">{{ "@".$son_soru->user->nickname }}</div>
                    <div
                        class="tt-col-value tt-color-select hide-mobile text-right">{{ $son_soru->comment()->where("status",1)->count() }}</div>
                    <div class="tt-col-value hide-mobile text-center">{{ $son_soru->goruntulenme }}</div>
                    <div
                        class="tt-col-value hide-mobile text-right">{{ date('d.m.Y',strtotime($son_soru->created_at)) }}</div>
                </div>

                @if($sayac==5)
                    {{-- BU KISIMDA TANITIM OLACAK --}}
                    @guest
                        <div class="tt-item tt-item-popup">
                            <div class="tt-col-message">
                                Aklında soruların varsa veya Seyyar'lara yardımcı olmak istiyorsan hemen bize katıl
                            </div>
                            <div class="tt-col-btn">
                                <a href="{{ route('front.signin.index') }}" class="btn btn-primary border-0">Giriş
                                    Yap</a>
                                <a href="{{ route('front.signup.index') }}" class="btn btn-secondary border-0">Kayıt
                                    Ol</a>
                            </div>
                        </div>
                    @endguest
                @endif

                @php
                    $sayac++;
                @endphp
            @empty
                <div class="col-md-12 alert alert-danger text-center">
                    Herhangi bir seyyar bu soruya benzer bir soru sormadı :)
                </div>
            @endforelse

            <div class="tt-row-btn">
                <button onclick="window.location.href='{{ route('front.index') }}'" type="button"
                        class="btn-icon js-topiclist-showmore">
                    <svg class="tt-icon">
                        <use xlink:href="#icon-load_lore_icon"></use>
                    </svg>
                </button>
            </div>
        </div>

    </div>
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

    <!-- SWEET ALERT KISMI AYARLAMASI -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


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
