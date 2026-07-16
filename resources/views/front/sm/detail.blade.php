@extends('front.layout.master')

@section('title',$kategori->kat_adi.' Kategorisi | '.$datalar['ayarlar']->site_baslik)
@section('description',$kategori->kat_desc)
@section('keywords',$kategori->kat_keyw)

{{-- OG ETIKETLERI --}}
@section('og_type',$kategori->kat_adi. "Kategorisi içerisinde sorulan sorular")
@section('og_title',$kategori->kat_desc)
@section('og_description',$kategori->kat_keyw)

{{-- TWITTER OG ETIKETLERI --}}
@section('tw_title',$kategori->kat_adi.' Kategorisi | '.$datalar['ayarlar']->site_baslik)
@section('tw_description',$kategori->kat_desc)

@section('css')

@endsection

@section('content')

    <section class="highlight-phone mt-5 mb-5" style="background-color: #fff; border-radius: 40px">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-md-6 mt-5">
                    <div class="intro">
                        <h2>{{ $kategori->kat_adi }}</h2>
                        <p>
                            {{ $kategori->kat_desc }}
                        </p>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="d-none d-md-block phone-mockup text-center">
                        @if($kategori->kat_photo != "" && \Illuminate\Support\Facades\File::exists("storage/".$kategori->kat_photo))
                            <img style="border-radius: 45px;" class="device" width="200" height="200"
                                 src="{{ asset('storage/'.$kategori->kat_photo) }}">
                        @else
                            <img style="border-radius: 45px;" class="device" width="200" height="200" src="{{ asset('storage/resim-yok.webp') }}">
                        @endif
                        <div class="screen"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="tt-topic-list">
        <div class="tt-list-header">
            <div class="tt-col-topic"><b>{{ $kategori->kat_adi." Kategorisi" }}</b></div>
            <div class="tt-col-category">Soru Durumu</div>
            <div class="tt-col-category">Kategori</div>
            <div class="tt-col-value hide-mobile">Kim Sordu</div>
            <div class="tt-col-value hide-mobile">Yanıtlanma</div>
            <div class="tt-col-value hide-mobile">İzlenme</div>
            <div class="tt-col-value">Zaman</div>
        </div>
        @php
            $sayac = 1;
        @endphp
        @forelse($questions as $question)
            <div class="tt-item tt-itemselect">
                <div class="tt-col-avatar">

                    @if($question->photo != "" && \Illuminate\Support\Facades\File::exists("storage/".$question->photo) && $question->profil_foto_gizle==0)
                        <img src="{{ asset('storage/'.$question->photo) }}" width="50" height="50"
                             alt="{{ $question->baslik }}" style="border-radius: 30px">
                    @else
                        <img src="{{ asset('storage/resim-yok.webp') }}" width="50" height="50"
                             alt="{{ $question->baslik }}" style="border-radius: 30px;">
                    @endif

                </div>
                <div class="tt-col-description">
                    <h6 class="tt-title">
                        <a href="{{ route('front.question.question_detail',$question->seflink) }}">
                            <svg class="tt-icon">
                                <use xlink:href="#icon-pinned"></use>
                            </svg>
                            {{ \Illuminate\Support\Str::words($question->baslik,10,"...") }}
                        </a></h6>
                </div>
                <div class="tt-col-category">
                    @if($question->cozumlenme==1)
                        <span class="tt-color01 tt-badge" style="background-color: green;">
                       Çözüldü
                        </span>
                    @else
                        <span class="tt-color01 tt-badge" style="background-color: #3ebafa;">
                       Çözüm Bekliyor
                        </span>
                    @endif
                </div>
                <div class="tt-col-category">
                    <span class="tt-color01 tt-badge mt-2">{{ $question->kat_adi }}</span>
                </div>
                <div class="tt-col-value hide-mobile">{{ "@".$question->nickname }}</div>
                <div
                    class="tt-col-value tt-color-select hide-mobile">{{ \App\Helper\myHelper::soruYorumSayi($question->question_id) }}</div>
                <div class="tt-col-value hide-mobile">{{ $question->goruntulenme }}</div>
                <div class="tt-col-value hide-mobile">{{ date('d.m.Y',strtotime($question->soru_paylasim)) }}</div>
            </div>

            @if($sayac==5)
                {{-- BU KISIMDA TANITIM OLACAK --}}
                <div class="tt-item tt-item-popup">
                    <div class="tt-col-message">
                        Aklında soruların varsa veya Seyyar'lara yardımcı olmak istiyorsan hemen bize katıl
                    </div>
                    <div class="tt-col-btn">
                        <a href="{{ route('front.signin.index') }}" class="btn btn-primary">Giriş Yap</a>
                        <a href="{{ route('front.signup.index') }}" class="btn btn-secondary">Kayıt Ol</a>
                    </div>
                </div>
            @endif

            @php
                $sayac++;
            @endphp
        @empty
            <div class="col-md-12 alert alert-danger text-center">
                Bu kategorriye ait herhangi bir soru bulunamadı
            </div>
        @endforelse

        <div class="pagination mt-5 d-flex justify-content-center">
            {{ $questions->links() }}
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
