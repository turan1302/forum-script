@extends('front.layout.master')

{{-- OG ETIKETLERI --}}
@section('og_type',"Gizlilik Politikası")
@section('og_title',"Sistemimizin gizlilik politikası sayfası işite bu kısımda")
@section('og_description',"gizlilik,gizlilik politikası,verilerin gizliliği,verilerin güvenliği")

@section('content')
    <div class="tt-topic-list">
        <div class="container d-flex justify-content-center mt-5">
            <div class="row">
                {!! $datalar['ayarlar']->site_gizlilik_politikasi !!}
            </div>
        </div>
    </div>
@endsection
