<header id="tt-header">
    <div class="container">
        <div class="row tt-row no-gutters">
            <div class="col-auto">
                <!-- toggle mobile menu -->
                <a class="toggle-mobile-menu" href="#">
                    <svg class="tt-icon">
                        <use xlink:href="#icon-menu_icon"></use>
                    </svg>
                </a>
                <!-- /toggle mobile menu -->
                <!-- logo -->
                <div class="tt-logo">
                    <a href="{{  route('front.index') }}"><img src="{{ asset('storage/'.$datalar['ayarlar']->site_icon) }}" width="65" height="73" alt="{{ $datalar['ayarlar']->site_baslik }}"></a>
                </div>
                <!-- /logo -->
                <!-- desctop menu -->
                <div class="tt-desktop-menu">
                    <nav>
                        <ul>
                            <li><a href="{{ route('front.category.index') }}"><span>Kategoriler</span></a></li>
                            <li><a href="{{ route('front.user_list') }}"><span>Üyeler</span></a></li>
                            <li><a href="{{ route('front.question.index') }}"><span>Yeni Soru Sor</span></a></li>
                            <li>
                            <li>
                                <a href="javascript:void(0)" class=""><span>{{ $datalar['ayarlar']->site_baslik }}</span></a>
                                <ul>
                                    <li><a href="{{ route('front.about') }}">Hakkımızda</a></li>
                                    <li><a href="{{ route('front.privacy') }}">Gizlilik Politikası</a></li>
                                    <li><a href="{{ route('front.kvkk') }}">KVKK Kapsamı</a></li>
                                </ul>
                            </li>
                            </li>
                        </ul>
                    </nav>
                </div>
                <!-- /desctop menu -->
                <!-- tt-search -->
                <div class="tt-search">
                    <!-- toggle -->
                    <button class="tt-search-toggle" data-toggle="modal" data-target="#modalAdvancedSearch">
                        <svg class="tt-icon">
                            <use xlink:href="#icon-search"></use>
                        </svg>
                    </button>
                    <!-- /toggle -->
                    <form action="{{ route('front.search') }}" class="search-wrapper" style="margin-top: 16px;"
                          method="GET">
                        <div class="search-form">
                            <input type="text" name="aranan" class="tt-search__input" placeholder="Arama Yap">
                            <button class="tt-search__btn" type="submit">
                                <svg class="tt-icon" style="margin-top: 6px;">
                                    <use xlink:href="#icon-search"></use>
                                </svg>
                            </button>
                            <button class="tt-search__close">
                                <svg class="tt-icon">
                                    <use xlink:href="#cancel"></use>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
                <!-- /tt-search -->
            </div>
            @guest
                <div class="col-auto ">
                    <div class="tt-account-btn">
                        <a href="{{ route('front.signin.index') }}" class="btn btn-primary ml-4 border-0"> Giriş</a>
                        <a href="{{ route('front.signup.index') }}" class="btn btn-secondary border-0">Kayıt</a>
                    </div>
                </div>
            @endguest

            @auth
                <div class="col-auto ml-auto">
                    <div class="tt-user-info d-flex justify-content-center">
                        <div class="tt-avatar-icon tt-size-md">
                            @if(auth()->user()->photo != "" && \Illuminate\Support\Facades\File::exists("storage/".auth()->user()->photo))
                                <img src="{{ asset('storage/'.auth()->user()->photo) }}" width="50" height="50"
                                     alt="{{ auth()->user()->name }}" style="border-radius: 30px">
                            @else
                                <img src="{{ asset('storage/resim-yok.webp') }}" width="50" height="50"
                                     alt="{{ auth()->user()->name }}" style="border-radius: 30px;">
                            @endif
                        </div>

                        <div class="custom-select-01">
                            <select class="userOp">
                                <option
                                    value="">{{ \Illuminate\Support\Str::limit(auth()->user()->name,8,'') }}</option>
                                <option value="{{ route('front.hesabim.index') }}">Hesabım</option>

                                <option value="{{ route('front.hesabim.notifications') }}">Bildirimler ({{ \App\Models\NotificationModel::where(array(
                                    "receiverUserId" => auth()->user()->id,
                                    "isRead" => 0
                                ))->count() }})
                                </option>

                                <option value="{{ route('front.hesabim.save_questions') }}">Kaydettiklerim</option>
                                <option value="{{ route('front.signin.logout') }}">Çıkış Yap
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
            @endauth
        </div>
    </div>
</header>
