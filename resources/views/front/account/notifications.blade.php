@extends('front.layout.master')

@section('title','Bildirimler | '.$datalar['ayarlar']->site_baslik)
@section('description',$datalar['ayarlar']->site_desc)
@section('keywords',$datalar['ayarlar']->site_keyw)

{{-- OG ETIKETLERI --}}
@section('og_type',auth()->user()->name)
@section('og_title',"Sistemimize abone olan seyyar yazılımcımız ".auth()->user()->name." için bildirim paneli")
@section('og_description',"Sorularınıza gelen yorumlar ve cevaplar bu alanda yer alır")

{{-- TWITTER OG ETIKETLERI --}}
@section('tw_title',auth()->user()->name.' | '.$datalar['ayarlar']->site_baslik)
@section('tw_description',"Sistemimize abone olan seyyar yazılımcımız ".auth()->user()->name." için bildirim paneli")

@if(auth()->user()->photo != "" && \Illuminate\Support\Facades\File::exists("storage/".auth()->user()->photo))
    @section('tw_image',asset('storage/'.auth()->user()->photo))
@endif


@section('css')

@endsection


@section('content')

    @include('front.layout.banner')


    <div class="container mt-5">
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">Bildirim Başlıkları</th>
            </tr>
            </thead>
            <tbody>
            @forelse($items as $item)
                <tr>
                    <td scope="row">{{ $item->text }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">
                        <div class="alert alert-danger text-center col-md-12">
                            Herhangi bir bildirim bulunamadı
                        </div>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>

        <div class="col-md-12 d-flex justify-content-center">
            {{ $items->links() }}
        </div>

    </div>
@endsection
