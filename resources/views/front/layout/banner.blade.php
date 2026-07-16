@if(!empty($banner))
    <section class="highlight-phone mt-5 mb-5" style="background-color: #fff; border-radius: 40px">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-md-6 mt-5">
                    <div class="intro">
                        <h2>{{ $banner->banner_baslik }}</h2>
                        <p>
                            {{ $banner->banner_aciklama }}
                        </p>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div style="transform: rotate(0deg);" class="d-none d-md-block phone-mockup text-center">
                        @if($banner->banner_foto != "" && \Illuminate\Support\Facades\File::exists("storage/".$banner->banner_foto))
                            <img class="device" width="200" height="200"
                                 src="{{ asset('storage/'.$banner->banner_foto) }}">
                        @else
                            <img class="device" width="200" height="200" src="{{ asset('storage/resim-yok.webp') }}">
                        @endif
                        <div class="screen"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
