<div class="col-md-8">
    <div class="tt-single-topic-list border mt-5">
        <div class="tt-item">
            <div class="tt-single-topic">
                <div class="tt-item-header">
                    <div class="tt-item-info info-top">
                        <div class="tt-avatar-icon">
                            @if($item->user->photo != "" && \Illuminate\Support\Facades\File::exists("storage/".$item->user->photo) && $item->user->profil_foto_gizle==0)
                                <img src="{{ asset('storage/'.$item->user->photo) }}" width="50" height="50"
                                     alt="{{ $item->baslik }}" style="border-radius: 30px">
                            @else
                                <img src="{{ asset('storage/resim-yok.webp') }}" width="50" height="50"
                                     alt="{{ $item->baslik }}" style="border-radius: 30px;">
                            @endif
                        </div>
                        <div class="tt-avatar-title">
                            <a href="javascript:void(0)">{{ "@".optional($item->user)->nickname }}</a>
                        </div>
                        <a href="#" class="tt-info-time">
                            <i class="tt-icon">
                                <svg>
                                    <use xlink:href="#icon-time"></use>
                                </svg>
                            </i>{{ date("d.m.Y",strtotime($item->created_at)) }}
                        </a>
                    </div>
                    <h3 class="tt-item-title">
                        <a href="#">{{ $item->baslik }}</a>
                    </h3>
                    <div class="tt-item-tag">
                        <ul class="tt-list-badge">
                            @forelse($item->question_category()->get() as $category)
                                <li><a href="#"><span
                                            class="tt-badge">{{ optional($category->categories)->kat_adi }}</span></a>
                                </li>
                            @empty
                            @endforelse
                        </ul>
                    </div>
                </div>
                <div class="tt-item-description">
                    {!! $item->text !!}
                </div>

                @auth
                    @if($item->user_id==auth()->user()->id)
                        <div class="mt-3">
                            <a href="{{ route('front.question.edit_question',$item->seflink) }}"
                               class="btn btn-secondary btn-sm btn-outline"><i class="fa fa-edit"></i> Sorumu
                                Güncelle</a>

                            <button data-url="{{ route('front.question.delete_question',$item->id) }}"
                                    type="button"
                                    class="btn btn-danger btn-sm deleteQuestion"><i
                                    class="fa fa-times-circle"></i>
                                Sorumu
                                Sil
                            </button>

                            <button data-url="{{ route('front.question.save_question',$item->id) }}"
                                    class="btn btn-success btn-sm saveQuestion">
                                @if(\App\Models\SaveQuestionModel::where("question_id",$item->id)->where("user_id",auth()->user()->id)->count()==0)
                                    <i class="fa fa-save"></i> Kaydet
                                @else
                                    <i class="fa fa-arrow-left"></i> Kayıttan Çıkar
                                @endif
                            </button>
                        </div>

                    @else
                        <div class="mt-3">
                            <button data-url="{{ route('front.question.save_question',$item->id) }}"
                                    class="btn btn-success btn-sm saveQuestion">
                                @if(\App\Models\SaveQuestionModel::where("question_id",$item->id)->where("user_id",auth()->user()->id)->count()==0)
                                    <i class="fa fa-save"></i> Kaydet
                                @else
                                    <i class="fa fa-arrow-left"></i> Kayıttan Çıkar
                                @endif
                            </button>
                        </div>
                    @endif
                @endauth

                <div class="tt-item-info info-bottom">
                    @auth
                        {{-- KULLANICI GIRISI VARSA --}}
                        @if($item->user_id!=auth()->user()->id)
                            {{-- KENDI YORUMUNU BEĞENEMESIN --}}
                            <button type="button" data-url="{{ route('front.question.like_or_disslike_question',$item->id) }}"
                                    class="btn btn-light questionLike {{ ($item->question_like_disslike()->where("user_id",auth()->user()->id)->where("question_id",$item->id)->where("status",1)->first()) ? 'isLike' : '' }} likeButton-{{ $item->id }}"
                                    data-comment="{{ $item->id }}"><i class="fa fa-thumbs-up"></i>
                                ({{ $item->question_like_disslike()->where("question_id",$item->id)->where("status",1)->count() }}
                                )
                            </button>
                            <button type="button" data-url="{{ route('front.question.like_or_disslike_question',$item->id) }}"
                                    class="btn btn-light questionDisslike {{ ($item->question_like_disslike()->where("user_id",auth()->user()->id)->where("question_id",$item->id)->where("status",-1)->first()) ? 'isDissLike' : '' }} disslikeButton-{{ $item->id }}"
                                    data-comment="{{ $item->id }}"><i class="fa fa-thumbs-down"></i>
                                ({{ $item->question_like_disslike()->where("question_id",$item->id)->where("status",-1)->count() }}
                                )
                            </button>
                        @else
                            {{-- EĞER KENDI YORUMU ISE --}}
                            <div class="container col-md-12">
                                <div class="row" style="white-space: nowrap;">
                                    <div class="col-md-6">
                                        <i class="fa fa-thumbs-up" style="color: #0E9A00;"></i>
                                        ({{ $item->question_like_disslike()->where("question_id",$item->id)->where("status",1)->count() }}
                                        )


                                        <i class="fa fa-thumbs-down ml-2" style="color: #7c2000"></i>
                                        ({{ $item->question_like_disslike()->where("question_id",$item->id)->where("status",-1)->count() }}
                                        )
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endauth

                    @guest
                        {{-- KULLANICI GIRISI YOKSA --}}
                        <div class="container">
                            <div class="row" style="white-space: nowrap;">
                                <div class="col-md-6">
                                    <i class="fa fa-thumbs-up"
                                       style="color: #0E9A00;"></i>({{ $item->question_like_disslike()->where("question_id",$item->id)->where("status",1)->count() }}
                                    )

                                    <i class="fa fa-thumbs-down ml-2"
                                       style="color: #7c2000"></i>({{ $item->question_like_disslike()->where("question_id",$item->id)->where("status",-1)->count() }}
                                    )
                                </div>
                            </div>
                        </div>
                    @endguest
                </div>


                @if(!empty($etiketler))
                    <div class="mt-5">
                        <label style="font-weight: bold;" for="">Etiketler</label>
                        <br>
                        @forelse($etiketler as $etiket)
                            <a href="{{ route('front.question.tag_detail',\Illuminate\Support\Str::slug($etiket)) }}"
                               class="btn btn-xs btn-light">{{ "#".$etiket }}</a>
                        @empty
                        @endforelse
                    </div>
                @endif

            </div>
        </div>

        <!-- YORUMLAR KISMI -->
    @if($dogruYanit)
        <!-- DOĞRU YANIT KISMI -->
            <div class="container d-flex justify-content-center">
                <div class="col-md-12 d-flex justify-content-center alert alert-success text-center">
                    Doğru Yanıtlayan Seyyar
                </div>
            </div>

            <div class="tt-item tt-wrapper-success mb-5">
                <div class="tt-single-topic">
                    <div class="tt-item-header pt-noborder">
                        <div class="tt-item-info info-top">
                            <div class="tt-avatar-icon">
                                @if($dogruYanit->user->photo != "" && \Illuminate\Support\Facades\File::exists("storage/".$dogruYanit->user->photo))
                                    <img src="{{ asset('storage/'.$dogruYanit->user->photo) }}" width="50"
                                         height="50"
                                         alt="{{ $item->baslik }}" style="border-radius: 30px">
                                @else
                                    <img src="{{ asset('storage/resim-yok.webp') }}" width="50" height="50"
                                         alt="{{ $item->baslik }}" style="border-radius: 30px;">
                                @endif
                            </div>
                            <div class="tt-avatar-title">
                                <a href="#">{{ optional($dogruYanit->user)->name." --- ".date('d.m.Y',strtotime($dogruYanit->created_at)) }}</a>
                                <span class="tt-color13 tt-badge">Doğru Yanıt</span>
                            </div>

                            @if(\Illuminate\Support\Facades\Auth::check() && auth()->user()->id==$dogruYanit->user_id)
                                {{-- SILME KISMI--}}
                                <a style="position:absolute; margin-top: -4%; margin-left: 88%;"
                                   data-url="{{ route('front.question.delete_comment') }}"
                                   href="javascript:void(0)" class="tt-info-time commentDelete"
                                   data-comment="{{ $dogruYanit->id }}">
                                    <i class="fa fa-times">
                                    </i>
                                </a>
                            @endif

                        </div>
                    </div>
                    <div class="tt-item-description">
                        {!! $dogruYanit->comment !!}
                    </div>

                    <div class="tt-item-info info-bottom">
                        @auth
                            {{-- KULLANICI GIRISI VARSA --}}
                            @if($dogruYanit->user_id!=auth()->user()->id)
                                {{-- KENDI YORUMUNU BEĞENEMESIN --}}
                                <button type="button"
                                        data-url="{{ route('front.question.like_or_disslike_comment') }}"
                                        class="btn btn-light commentLike {{ ($dogruYanit->comment_like_disslike()->where("user_id",auth()->user()->id)->where("comment_id",$dogruYanit->id)->where("status",1)->first()) ? 'isLike' : '' }} likeButton-{{ $dogruYanit->id }}"
                                        data-comment="{{ $dogruYanit->id }}"><i class="fa fa-thumbs-up"></i>
                                    ({{ $dogruYanit->comment_like_disslike()->where("comment_id",$dogruYanit->id)->where("status",1)->count() }}
                                    )
                                </button>
                                <button type="button"
                                        data-url="{{ route('front.question.like_or_disslike_comment') }}"
                                        class="btn btn-light commentDisslike {{ ($dogruYanit->comment_like_disslike()->where("user_id",auth()->user()->id)->where("comment_id",$dogruYanit->id)->where("status",-1)->first()) ? 'isDissLike' : '' }} disslikeButton-{{ $dogruYanit->id }}"
                                        data-comment="{{ $dogruYanit->id }}"><i class="fa fa-thumbs-down"></i>
                                    ({{ $dogruYanit->comment_like_disslike()->where("comment_id",$dogruYanit->id)->where("status",-1)->count() }}
                                    )
                                </button>
                            @else
                                {{-- EĞER KENDI YORUMU ISE --}}
                                <div class="container col-md-12">
                                    <div class="row" style="white-space: nowrap;">
                                        <div class="col-md-6">
                                            <i class="fa fa-thumbs-up" style="color: #0E9A00;"></i>
                                            ({{ $dogruYanit->comment_like_disslike()->where("comment_id",$dogruYanit->id)->where("status",1)->count() }}
                                            )


                                            <i class="fa fa-thumbs-down ml-2" style="color: #7c2000"></i>
                                            ({{ $dogruYanit->comment_like_disslike()->where("comment_id",$dogruYanit->id)->where("status",-1)->count() }}
                                            )
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endauth

                        @guest
                            {{-- KULLANICI GIRISI YOKSA --}}
                            <div class="container">
                                <div class="row" style="white-space: nowrap;">
                                    <div class="col-md-6">
                                        <i class="fa fa-thumbs-up"
                                           style="color: #0E9A00;"></i>({{ $dogruYanit->comment_like_disslike()->where("comment_id",$dogruYanit->id)->where("status",1)->count() }}
                                        )

                                        <i class="fa fa-thumbs-down ml-2"
                                           style="color: #7c2000"></i>({{ $dogruYanit->comment_like_disslike()->where("comment_id",$dogruYanit->id)->where("status",-1)->count() }}
                                        )
                                    </div>
                                </div>
                            </div>
                        @endguest
                    </div>
                </div>
            </div>
    @endif

    <!-- YORUM KISMI -->

        @if($comments->count() > 0)
            <div class="container d-flex justify-content-center">
                <div class="col-md-12 d-flex justify-content-center alert alert-primary text-center">
                    Diğer Seyyar'ların Yanıtları
                </div>
            </div>
        @endif

        @forelse($comments as $comment)
            <div class="tt-item border">
                <div class="tt-single-topic">
                    <div class="tt-item-header pt-noborder">
                        <div class="tt-item-info info-top">
                            <div class="tt-avatar-icon">
                                @if($comment->user->photo != "" && \Illuminate\Support\Facades\File::exists("storage/".$comment->user->photo))
                                    <img src="{{ asset('storage/'.$comment->user->photo) }}" width="50"
                                         height="50"
                                         alt="{{ $comment->user->name }}" style="border-radius: 30px">
                                @else
                                    <img src="{{ asset('storage/resim-yok.webp') }}" width="50" height="50"
                                         alt="{{ $comment->user->name }}" style="border-radius: 30px;">
                                @endif
                            </div>
                            <div class="tt-avatar-title">
                                <a href="#">{{ optional($comment->user)->name." --- ".date('d.m.Y',strtotime($comment->created_at)) }}</a>
                            </div>

                            @if(\Illuminate\Support\Facades\Auth::check() && auth()->user()->id==$comment->user_id)
                                {{-- SILME KISMI--}}
                                <a href="javascript:void(0)"
                                   data-url="{{ route('front.question.delete_comment') }}"
                                   class="tt-info-time commentDelete"
                                   data-comment="{{ $comment->id }}">
                                    <i class="fa fa-times">
                                    </i>
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="tt-item-description">
                        {!! $comment->comment !!}
                    </div>
                    <div class="tt-item-info info-bottom">
                        @auth
                            {{-- KULLANICI GIRISI VARSA --}}
                            @if($comment->user_id!=auth()->user()->id)
                                {{-- KENDI YORUMUNU BEĞENEMESIN --}}
                                <button type="button"
                                        data-url="{{ route('front.question.like_or_disslike_comment') }}"
                                        class="btn btn-light commentLike {{ ($comment->comment_like_disslike()->where("user_id",auth()->user()->id)->where("comment_id",$comment->id)->where("status",1)->first()) ? 'isLike' : '' }} likeButton-{{ $comment->id }}"
                                        data-comment="{{ $comment->id }}"><i class="fa fa-thumbs-up"></i>
                                    ({{ $comment->comment_like_disslike()->where("comment_id",$comment->id)->where("status",1)->count() }}
                                    )
                                </button>
                                <button type="button"
                                        data-url="{{ route('front.question.like_or_disslike_comment') }}"
                                        class="btn btn-light commentDisslike {{ ($comment->comment_like_disslike()->where("user_id",auth()->user()->id)->where("comment_id",$comment->id)->where("status",-1)->first()) ? 'isDissLike' : '' }} disslikeButton-{{ $comment->id }}"
                                        data-comment="{{ $comment->id }}"><i class="fa fa-thumbs-down"></i>
                                    ({{ $comment->comment_like_disslike()->where("comment_id",$comment->id)->where("status",-1)->count() }}
                                    )
                                </button>
                            @else
                                {{-- EĞER KENDI YORUMU ISE --}}
                                <div class="container col-md-12">
                                    <div class="row" style="white-space: nowrap;">
                                        <div class="col-md-6">
                                            <i class="fa fa-thumbs-up" style="color: #0E9A00;"></i>
                                            ({{ $comment->comment_like_disslike()->where("comment_id",$comment->id)->where("status",1)->count() }}
                                            )


                                            <i class="fa fa-thumbs-down ml-2" style="color: #7c2000"></i>
                                            ({{ $comment->comment_like_disslike()->where("comment_id",$comment->id)->where("status",-1)->count() }}
                                            )
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endauth

                        @guest
                            {{-- KULLANICI GIRISI YOKSA --}}
                            <div class="container">
                                <div class="row" style="white-space: nowrap;">
                                    <div class="col-md-6">
                                        <i class="fa fa-thumbs-up"
                                           style="color: #0E9A00;"></i>({{ $comment->comment_like_disslike()->where("comment_id",$comment->id)->where("status",1)->count() }}
                                        )

                                        <i class="fa fa-thumbs-down ml-2"
                                           style="color: #7c2000"></i>({{ $comment->comment_like_disslike()->where("comment_id",$comment->id)->where("status",-1)->count() }}
                                        )
                                    </div>
                                </div>
                            </div>
                        @endguest
                        <div class="col-separator"></div>

                        @auth
                            @if(auth()->user()->id==$item->user_id && auth()->user()->id != $comment->user_id)
                                {{-- DOĞRU CEVABI SEÇME KISMI AYARLAMASI --}}
                                <button style="background-color: #3cb878; border-color: transparent;"
                                        type="button"
                                        data-comment="{{ $comment->id }}"
                                        data-question="{{ $item->id }}"
                                        data-url="{{ route('front.question.isCorrect') }}"
                                        class="btn btn-success btn-sm btn-outline isCorrect isCorrectMobile isCorrectDesktop">
                                    <i class="fa fa-check-circle"></i> Onayla
                                </button>
                            @endif
                        @endauth

                    </div>
                </div>
            </div>
        @empty
            {{-- EĞER DOĞRU YANIT KISMI DA YORUMLAR DA BOŞ İSE --}}
            @if(empty($dogruYanit) && empty($comments))
                <div class="container">
                    <div class="col-md-12 alert alert-danger text-center">
                        Bu seyyar'ın sorusuna herhangi bir yardım bulunamadı. İlk yardımı sen yap :)
                    </div>
                </div>
            @endif
        @endforelse

        {{-- EĞER SORU KAPATILMIŞ İSE --}}
        @if($item->cozumlenme==1)
            <div class="container mt-2">
                <div class="col-md-12 alert alert-danger text-center">
                    Bu seyyar'ın sorusu kapanmış. Diğer seyyarlar yardım bekliyor :)
                </div>
            </div>
        @endif

    </div>

    {{-- SORU COZUMLENMEDIYSE BU YAZSIN --}}
    @if($item->cozumlenme==0)
        <div class="tt-wrapper-inner">
            <h4 class="tt-title-separator">
                <span>Seyyar dostuna bir yardımın dokunmasını istiyorsan yorum bırakabilirsin :)</span></h4>
        </div>
    @endif

    @guest
        <div class="tt-topic-list">
            <div class="tt-item tt-item-popup">
                <div class="tt-col-message">
                    Aklında soruların varsa veya Seyyar'lara yardımcı olmak istiyorsan hemen bize katıl
                </div>
                <div class="tt-col-btn">
                    <a href="{{ route('front.signin.index') }}" class="btn btn-primary border-0">Giriş Yap</a>
                    <a href="{{ route('front.signup.index') }}" class="btn btn-secondary border-0">Kayıt Ol</a>
                </div>
            </div>
        </div>
    @endguest

    @auth
        {{-- SORU KAPANMADIYSA YORUM KISMI GOZUKSUN --}}
        @if($item->cozumlenme==0)
            <form action="{{ route('front.question.do_comment',$item->id) }}" method="POST">
                @csrf
                <div class="tt-wrapper-inner">
                    <div class="pt-editor form-default">
                        <h6 class="pt-title">Hemen Yardımcı Ol</h6>
                        <div class="pt-row justify-content-end">
                            <div class="col-right tt-hidden-mobile">
                                <a href="#" class="btn btn-primary">Soruyu Gör</a>
                            </div>
                        </div>

                        <ul>
                            <li>Resim Eklemek <a href="https://www.hizliresim.com/" target="_blank">Hızlı Resim</a> Sitesindeki Linki Yerleştirin</li>
                            <li>Kod Eklemek İçin Tinymce Kod Editörünü Kullanınız</li>
                            <li>Argo, Siyasi ve Hakaret İçerikler Kullanmayınız</li>
                        </ul>
                        <div class="form-group">
                        <textarea name="comment" class="editor" rows="5"
                                  placeholder="Hemen Yorum Yap">{{ old('comment') ?? '' }}</textarea>
                            @error('comment')
                            <small style="color: red;">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="pt-row justify-content-end">
                            <div class="col-auto">
                                <button type="submit" class="btn btn-secondary btn-width-lg">Yorum Yap</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        @endif
    @endauth

    @guest
        <div class="container">
            <div class="col-md-12 alert alert-danger mt-4 text-center">
                Yorum Yapmak İçin Giriş Yapmalısınız
            </div>
        </div>
    @endguest
</div>
