@extends('front.layout.master')

{{-- OG ETIKETLERI --}}
@section('og_type',"KVKK Kapsamı")
@section('og_title',"Kvkk kapsamına uygun sekilde verileriniz saklanıyor")
@section('og_description',"kvkk,kişisel verilerin korunması kanunu,gizlilik,güvenlik")

@section('content')
    <div class="tt-topic-list">
        <div class="container d-flex justify-content-center mt-5">
            <div class="row">
                {!! $datalar['ayarlar']->site_kvkk !!}
            </div>
        </div>
    </div>
    @endsection

