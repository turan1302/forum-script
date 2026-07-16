@extends('front.layout.master')

@section('title','Kayıtlı Sorular | '.$datalar['ayarlar']->site_baslik)
@section('description',$datalar['ayarlar']->site_desc)
@section('keywords',$datalar['ayarlar']->site_keyw)

{{-- OG ETIKETLERI --}}
@section('og_type',auth()->user()->name)
@section('og_title',"Sistemimize abone olan seyyar yazılımcımız ".auth()->user()->name." 'nin kayıt ettiği sorular")
@section('og_description',"Sistem üzerinde kayıt ettiğiniz sorular tam da bu noktada")

{{-- TWITTER OG ETIKETLERI --}}
@section('tw_title',auth()->user()->name.' | '.$datalar['ayarlar']->site_baslik)
@section('tw_description',"Sistemimize abone olan seyyar yazılımcımız ".auth()->user()->name." 'nin kayıt ettiği sorular")

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
                <th scope="col">Başlık</th>
                <th scope="col">Yayın Tarihi</th>
                <th scope="col">İşlemler</th>
            </tr>
            </thead>
            <tbody>
            @forelse($items as $item)
                <tr>
                    <td scope="row">{{ $item->baslik }}</td>
                    <td>{{ $item->created_at }}</td>
                    <td>
                        <a href="{{ route('front.question.question_detail',$item->seflink) }}"
                           class="btn btn-primary btn-sm"><i class="fa fa-plane"></i> Yazıya Ulaş</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">
                        <div class="alert alert-danger text-center col-md-12">
                            Herhangi bir kayıt ettğiniz yazı bulunamadı
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
