<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('back.home.index') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Seyyar'a Sor</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('back.home.index') }}">
            <i class="fas fa-fw fa-home"></i>
            <span>Anasayfa</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!--KATEGORILER KISMI -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#kategoriler"
           aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-list"></i>
            <span>Kategoriler</span>
        </a>
        <div id="kategoriler" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('back.categories.index') }}">Kategoriler</a>
                <a class="collapse-item" href="{{ route('back.categories.create') }}">Kategori Ekle</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- SOSYAL MEDYA KISMI -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#sm"
           aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-comments"></i>
            <span>Sosyal Medya</span>
        </a>
        <div id="sm" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('back.sm.index') }}">Sosyal Medya</a>
                <a class="collapse-item" href="{{ route('back.sm.create') }}">Sosyal Medya Ekle</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- BANNERLAR KISMI -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#bannerlar"
           aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-images"></i>
            <span>Bannerlar</span>
        </a>
        <div id="bannerlar" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('back.banners.index') }}">Bannerlar</a>
                <a class="collapse-item" href="{{ route('back.banners.create') }}">Banner Ekle</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- SORULAR KISMI -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#sorular"
           aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-question"></i>
            <span>Sorular</span>
        </a>
        <div id="sorular" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('back.questions.index') }}">Tüm Sorular</a>
                <a class="collapse-item" href="{{ route('back.questions.cevaplanmis') }}">Cevaplanmış Sorular</a>
                <a class="collapse-item" href="{{ route('back.questions.cozumlenmis') }}">Çözümlenmiş Sorular</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- YORUMLAR KISMI -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#yorumlar"
           aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-comment"></i>
            <span>Yorumlar</span>
        </a>
        <div id="yorumlar" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('back.comments.index') }}">Tüm Yorumlar</a>
                <a class="collapse-item" href="{{ route('back.comments.yayinlanmis') }}">Yayınlanmış Yorumlar</a>
                <a class="collapse-item" href="{{ route('back.comments.yayinlanmamis') }}">Yayınlanmamış Yorumlar</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('back.notifications.index') }}">
            <i class="fas fa-fw fa-exclamation-triangle"></i>
            <span>Bildirimler</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('back.uyeler.index') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Üyeler</span></a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#sayfalar"
           aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-pager"></i>
            <span>Sayfalar</span>
        </a>
        <div id="sayfalar" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('back.settings.about') }}">Hakkında</a>
                <a class="collapse-item" href="{{ route('back.settings.privacy') }}">Gizlilik Politikası</a>
                <a class="collapse-item" href="{{ route('back.settings.kvkk') }}">KVKK Kapsamı</a>
            </div>
        </div>
    </li>


    <hr class="sidebar-divider d-none d-md-block">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('back.settings.index') }}">
            <i class="fas fa-fw fa-cogs"></i>
            <span>Ayarlar</span></a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">


    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>


</ul>
<!-- End of Sidebar -->
