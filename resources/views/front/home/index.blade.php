@extends('front.layout.master')

{{-- TITLE KISMI AYARLANMASI --}}
@section('title','Seyyar Yazılımcıların Buluşma Noktası')

@section('content')

    @include('front.layout.banner')

    <div class="tt-topic-list">
        <div class="container mt-5 mb-4">
            <h5>Son Sorular</h5>
            <a href="{{ route('front.cevaplanmis') }}">Cevaplanmış Sorular</a> | <a
                href="{{ route('front.cozumlenmis') }}">Çözümlenmiş Sorular</a>

        </div>

        <div class="tt-list-header">
            <div class="tt-col-topic">Seyyar'ın Sorusu</div>
            <div class="tt-col-category">Soru Durumu</div>
            <div class="tt-col-category">Kategori</div>
            <div class="tt-col-value hide-mobile">Kim Sordu</div>
            <div class="tt-col-value hide-mobile text-center">Yanıtlanma</div>
            <div class="tt-col-value hide-mobile text-center">İzlenme</div>
            <div class="tt-col-value text-center">Zaman</div>
        </div>
        @php
            $sayac = 1;
        @endphp
        @forelse($questions as $question)
            <div class="tt-item tt-itemselect">
                <div class="tt-col-avatar">

                    @if($question->user->photo != "" && \Illuminate\Support\Facades\File::exists("storage/".$question->user->photo) && $question->user->profil_foto_gizle==0)
                        <img src="{{ asset('storage/'.$question->user->photo) }}" width="50" height="50"
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
                        </a>
                    </h6>
                    <div class="row align-items-center no-gutters">

                        @if(!empty(optional(optional($question->comment()->with("user")->where("status",1)->orderBy("comments.id","desc")->first())->user)->name))
                            <span style="white-space: nowrap;"><b>Son Yorum Yapan:</b> {{ optional(optional($question->comment()->with("user")->where("status",1)->orderBy("comments.id","desc")->first())->user)->name }}</span>
                        @endif

                        <div class="col-11">
                            <ul class="tt-list-badge">
                                @forelse($question->question_category as $kategori)
                                    <li class="show-mobile">
                                        <a href="{{ route('front.category.category_detail',optional($kategori->categories)->kat_slug) }}">
                                            <span
                                                class="tt-color01 tt-badge">{{ optional($kategori->categories)->kat_adi }}</span>
                                        </a>
                                    </li>
                                @empty
                                @endforelse
                            </ul>
                        </div>
                    </div>
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
                    @forelse($question->question_category as $kategori)
                        <a href="{{ route('front.category.category_detail',optional($kategori->categories)->kat_slug) }}">
                            <span class="tt-color01 tt-badge mt-2">{{ optional($kategori->categories)->kat_adi }}</span>
                        </a>
                    @empty
                    @endforelse
                </div>
                <div class="tt-col-value hide-mobile text-center">{{ "@".$question->user->nickname }}</div>
                <div
                    class="tt-col-value tt-color-select hide-mobile text-right">{{ $question->comment()->where("status",1)->count() }}</div>
                <div class="tt-col-value hide-mobile text-center">{{ $question->goruntulenme }}</div>
                <div
                    class="tt-col-value hide-mobile text-center">{{ date('d.m.Y',strtotime($question->created_at)) }}</div>
            </div>

            @if($sayac==5)
                @if(!auth()->check())
                    {{-- BU KISIMDA TANITIM OLACAK --}}
                    <div class="tt-item tt-item-popup">
                        <div class="tt-col-message">
                            Aklında soruların varsa veya Seyyar'lara yardımcı olmak istiyorsan hemen bize katıl
                        </div>
                        <div class="tt-col-btn">
                            <a href="{{ route('front.signin.index') }}" class="btn btn-primary border-0">Giriş Yap</a>
                            <a href="{{ route('front.signup.index') }}" class="btn btn-secondary border-0">Kayıt Ol</a>
                        </div>
                    </div>
                @endif
            @endif

            @php
                $sayac++;
            @endphp
        @empty
            <div class="col-md-12 alert alert-danger text-center mt-5">
                Sorusu olan seyyar yok :) Hepsi çalışıyor
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
