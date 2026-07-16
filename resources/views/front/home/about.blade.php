@extends('front.layout.master')

@section('content')
    <div class="tt-topic-list">
        <div class="container d-flex justify-content-center mt-5">
            <div class="row">
                {!! $datalar['ayarlar']->site_hakkinda !!}
            </div>
        </div>
    </div>
    @endsection

