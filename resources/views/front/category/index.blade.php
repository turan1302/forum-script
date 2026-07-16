@extends('front.layout.master')

@section('title','Kategoriler | '.$datalar['ayarlar']->site_baslik)
@section('description',$datalar['ayarlar']->site_desc)
@section('keywords',$datalar['ayarlar']->site_keyw)

{{-- OG ETIKETLERI --}}
@section('og_type',"Kategoriler")
@section('og_title',"Sistemimizde yer alan kategoriler bu alanda yer alır")
@section('og_description',"kategoriler,kategori,yazılım kategorileri,yazılım,yazılım dünyası")

{{-- TWITTER OG ETIKETLERI --}}
@section('tw_title','Kategoriler | '.$datalar['ayarlar']->site_baslik)
@section('tw_description',"Sistemimizde yer alan kategoriler bu alanda yer alır")

@section('content')

    @include('front.layout.banner')

    <div class="tt-categories-title mt-4">
        <div class="tt-title">Kategoriler</div>
    </div>
    <div class="tt-categories-list">
        <div class="row">
            @forelse($categories as $category)
                <div class="col-md-6 col-lg-4">
                    <div class="tt-item border rounded" style="border-color: #383e42 !important; border-radius: 2rem !important;">
                        <div class="tt-item-header">
                            <ul class="tt-list-badge">
                                <li><a href="{{ route('front.category.category_detail',$category->kat_slug) }}"><span class="tt-color01 tt-badge">{{ $category->kat_adi }}</span></a>
                                </li>
                            </ul>
                            <h6 class="tt-title"><a href="javascript:void(0)">Toplam Soru - {{ $category->question_category()->count(). " (Onaylı ve Onaysız)" }}</a></h6>
                        </div>
                        <div class="tt-item-layout">
                            <div class="innerwrapper">
                                {{ $category->kat_desc }}
                            </div>
                            @if(!empty($category->kat_keyw))
                                <div class="innerwrapper">
                                    <h6 class="tt-title">Etiketler</h6>
                                    <ul class="tt-list-badge">
                                        @php
                                            $etiketler = explode(",",$category->kat_keyw);
                                        @endphp

                                        @forelse($etiketler as $k =>$v)
                                            <li><a href="#"><span class="tt-badge">{{ $v }}</span></a></li>
                                        @empty
                                        @endforelse
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
            @endforelse

                <div class="pagination mt-5 d-flex justify-content-center">
                    {{ $categories->links() }}
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
