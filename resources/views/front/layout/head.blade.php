<meta charset="utf-8">
<title>@yield('title',$datalar['ayarlar']->site_baslik)</title>
<meta name="description" content="@yield('description',$datalar['ayarlar']->site_desc)">
<meta name="keywords" content="@yield('keywords',$datalar['ayarlar']->site_keyw)">
<meta name="author" content="{{ $datalar['ayarlar']->site_baslik }}">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="publisher" content="{{ $datalar['ayarlar']->site_baslik }}">
<meta name='robots' content='index,follow'/>
<meta name="google-site-verification" content="OhVixCyLOtv5IlFTk5N_KQzzQe7YBiKpmuY2EZXcj-I"/>
<meta name="msvalidate.01" content="C2B5547A1BAC0C670615EAC6CA13BB23"/>
<meta name="yandex-verification" content="587d99cda3b8381a"/>
<meta property="og:url" content="{{ request()->url() }}"/>
<meta property="og:type" content="article"/>
<meta property="og:title" content="@yield('og_title',"Seyyar Yazılımcıların Buluşma Noktası")"/>
<meta property="og:description" content="@yield('og_description',$datalar['ayarlar']->site_desc)"/>
<meta property="og:locale" content="tr_TR">
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:site" content="{{ request()->url() }}" />
<meta name="twitter:creator" content="@yield('tw_creator',$datalar['ayarlar']->site_baslik)" />
<meta name="twitter:title" content="@yield('tw_title',$datalar['ayarlar']->site_baslik)" />
<meta name="twitter:description" content="@yield('tw_description',$datalar['ayarlar']->site_desc)"/>
<meta name="twitter:image:src" content="@yield('tw_image',asset('storage/'.$datalar['ayarlar']->site_icon))"/>
