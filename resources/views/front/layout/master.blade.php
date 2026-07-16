<!doctype html>
<html lang="tr">
<head>
    @include('front.layout.head')
    @include('front.layout.include_style')
    @yield('css')
    <style>
        .preloader {
            position: fixed;
            left: 0;
            top: 0;
            z-index: 3000;
            width: 100%;
            height: 100%;
            overflow: visible;
            background: #fff url('{{ asset('storage/preloader.webp') }}') no-repeat center center;
        }
    </style>
</head>
<body onload="myPreloader()">

<!-- tt-mobile menu -->
@include('front.layout.mobile.navbar')
@include('front.layout.header')
<div class="preloader"></div>
<main id="tt-pageContent" class="tt-offset-small">
    <div class="container">
        @yield('content')
    </div>
</main>

{{-- MOBIL ARAMA KISMI --}}
@include('front.layout.mobile.search')

{{-- ANASAYFA KISMINDAN GELECEK BURASI --}}
@yield('content2')

<div style="display:none">
    <h1>Seyyar Yazılımcı | Seyyar Yazılımcıların Buluşma Noktası</h1>
    <h2>Yazılım hakkında soru cevaplar</h2>
    <h3>Yazılım hakkında bilgi alış verişi</h3>
    <h4>Mobil uygulama geliştirme hakkında soru cevaplar</h4>
    <h5>İnoasyon hakkında soru cevaplar</h5>
    <h6>Seyyar Yazılımcıların Adresi</h6>
    <b>Gelecek İçin Kodla</b>
    <em>Seyyar yazılımcılar tek platformda</em>
    <strong>Javascript Hakkında Soru ve Cevaplar</strong>
    <i>CSS Hakkında Soru Cevaplar</i>
</div>

<footer class="footer-basic">
    <div class="social">
        @forelse($datalar['sm'] as $sosyal_medya)
            <a href="{{ route('front.sosyal_medya',$sosyal_medya->sm_anahtar) }}" target="_blank"><i class="{{ $sosyal_medya->sm_icon }}"></i></a>
        @empty
        @endforelse
    </div>
    <p class="copyright">{{ $datalar['ayarlar']->site_baslik }} © {{ date('Y') }}</p>
</footer>

@include('front.layout.include_script')
@yield('js')


<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-BZZJYM02KT"></script>
<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }

    gtag('js', new Date());

    gtag('config', 'G-BZZJYM02KT');
</script>
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4067317178165226"
        crossorigin="anonymous"></script>

<script>

    function myPreloader() {
        $('.preloader').fadeOut();
    }
</script>
</body>
</html>
