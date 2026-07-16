@extends('front.layout.master')
@section('css')
    <link rel="stylesheet" href="{{ asset('front') }}/user_list/style.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
@endsection
@section('title','Üyelerimiz | '.$datalar['ayarlar']->site_baslik)
@section('description','Sistemimize kayıtlı olan seyyarlarımız ')
@section('keywords','seyyar,soru,cevap,answer,question')
{{-- OG ETIKETLERI --}}
@section('og_type',"Üyelerimiz")
@section('og_title',"Sistemimize kayıtlı olan seyyar yazılımcılarımıza göz atabilirsiniz")
@section('og_description',"seyyar,yazılımcı,seyyar yazılımıcı,programcı,geliştirici,yazılım mühendisi,yazılım dünyası")

@section('content')

    @include('front.layout.banner')

    <div class="tt-topic-list">
        <section class="container py-5">
            <h2 class="h4 block-title text-center mt-2">Sistemimize kayıtlı olan kullanıcılar</h2>
            <div class="row pt-3">
                <!-- Author-->
                @forelse($items as $item)
                    <div class="col-lg-3 col-sm-6 mb-30 pb-2">
                        <div class="team-card-style-3 mx-auto">
                            <div class="team-thumb">
                                @if($item->photo != "" && \Illuminate\Support\Facades\File::exists("storage/".$item->photo) && $item->profil_foto_gizle==0)
                                    <img src="{{ asset('storage/'.$item->photo) }}" alt="{{ $item->name }}">
                                @else
                                    <img src="{{ asset('storage/resim-yok.webp') }}" alt="{{ $item->name }}">
                                @endif
                            </div>
                            <h4 class="team-name">
                                <a target="_blank" href="{{ route('front.user_detail',$item->nickname) }}">
                                    {{ $item->name }}
                                    @if($item->dogru_yanit_sayisi >= 50)
                                        <i class="fas fa-check-circle text-success"></i>
                                    @endif
                                </a>
                            </h4>

                            @if($item->phone != "" && $item->telefon_gizle==0)
                                <a class="team-contact-link" href="tel:{{ $item->phone }}"><i class="fe-icon-phone"></i>&nbsp;{{ $item->phone }}
                                </a>
                            @endif

                            @if($item->email != "" && $item->email_gizle==0)
                                <a class="team-contact-link" href="mailto:{{ $item->email }}"><i
                                        class="fe-icon-mail"></i>&nbsp;{{ $item->email }}</a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-md-12 alert alert-danger text-center">
                        Herhangi bir kullanıcı bulunamadı
                    </div>
                @endforelse
            </div>
        </section>

        <div class="d-flex justify-content-center">
            {{ $items->links() }}
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
