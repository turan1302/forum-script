@extends('front.layout.master')
@section('title',$item->name.' | '.$datalar['ayarlar']->site_baslik)
@section('description',$datalar['ayarlar']->site_desc)
@section('keywords',$datalar['ayarlar']->site_keyw)
@section('og_type',$item->name. " Seyyar yazılımcısının bilgileri")
@section('og_title',$item->name)
@section('og_description',\Illuminate\Support\Str::words($item->bio,20))
@section('tw_title',$item->name.' Seyyar yazılımcısının bilgileri | '.$datalar['ayarlar']->site_baslik)
@section('tw_description',\Illuminate\Support\Str::words($item->bio,20))
@if($item->photo != "" && \Illuminate\Support\Facades\File::exists("storage/".$item->photo))
    @section('tw_image',asset('storage/'.$item->photo))
@endif
@section('css')
    <link rel="stylesheet" href="{{ asset('front') }}/user_profile/style.css">
@endsection
@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-lg-4">
                <div class="profile-card-4 z-depth-3">
                    <div class="card">
                        <div class="card-body text-center bg-primary rounded-top">
                            <div class="user-box">
                                @if($item->photo != "" && \Illuminate\Support\Facades\File::exists("storage/".$item->photo) && $item->profil_foto_gizle==0)
                                    <img src="{{ asset('storage/'.$item->photo) }}" alt="{{ $item->name }}">
                                @else
                                    <img src="{{ asset('storage/resim-yok.webp') }}" alt="{{ $item->name }}">
                                @endif
                            </div>
                            <h5 class="mb-1 text-white">{{ $item->name }}
                                @if($item->dogru_yanit_sayisi >= 50)
                                    <i class="fas fa-check-circle text-white"></i>
                                @endif
                            </h5>
                            <h6 class="text-light">{{ $item->job }}</h6>
                        </div>
                        <div class="card-body">
                            <ul class="list-group shadow-none">
                                @if($item->phone != "" && $item->telefon_gizle==0)
                                    <li class="list-group-item">
                                        <div class="list-icon">
                                            <i class="fa fa-phone-square"></i>
                                        </div>
                                        <div class="list-details">
                                            <span>{{ $item->phone }}</span>
                                            <small>Telefon Numarası</small>
                                        </div>
                                    </li>
                                @endif

                                @if(!empty($item->email) && $item->email_gizle==0)
                                    <li class="list-group-item">
                                        <div class="list-icon">
                                            <i class="fa fa-envelope"></i>
                                        </div>
                                        <div class="list-details">
                                            <span>{{ $item->email }}</span>
                                            <small>E-Mail Adresiniz</small>
                                        </div>
                                    </li>
                                @endif

                                @if(!empty($item->website))
                                    <li class="list-group-item">
                                        <div class="list-icon">
                                            <i class="fa fa-globe"></i>
                                        </div>
                                        <div class="list-details">
                                            <span>{{ $item->website }}</span>
                                            <small>Websiteniz</small>
                                        </div>
                                    </li>
                                @endif
                            </ul>
                            <div class="row text-center mt-4">
                                <div class="col p-2">
                                    <h4 class="mb-1 line-height-5">{{ \App\Models\QuestionsModel::where(array(
    "user_id" => $item->id,
    "status"=>1
))->count() }}</h4>
                                    <small class="mb-0 font-weight-bold">Soru</small>
                                </div>
                                <div class="col p-2">
                                    <h4 class="mb-1 line-height-5">{{ \App\Models\CommentsModel::where(array(
    "user_id" => $item->id,
    "status" => 1
))->count() }}</h4>
                                    <small class="mb-0 font-weight-bold">Yorum</small>
                                </div>
                                <div class="col p-2">
                                    <h4 class="mb-1 line-height-5">{{ \App\Models\CommentsModel::where(array(
    "user_id" => $item->id,
    "is_true" => 1,
    "status" => 1
))->count() }}</h4>
                                    <small class="mb-0 font-weight-bold">Doğru Cevap</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card z-depth-3">
                    <div class="card-body">
                        <ul class="nav nav-pills nav-pills-primary nav-justified">
                            <li class="nav-item">
                                <a href="javascript:void();" data-target="#profile" data-toggle="pill"
                                   class="nav-link active show"><i class="icon-user"></i> <span
                                        class="hidden-xs">Profil</span></a>
                            </li>
                            <li class="nav-item">
                                <a href="javascript:void();" data-target="#messages" data-toggle="pill"
                                   class="nav-link"><i class="icon-envelope-open"></i> <span
                                        class="hidden-xs">Sorular</span></a>
                            </li>
                            <li class="nav-item">
                                <a href="javascript:void();" data-target="#edit" data-toggle="pill" class="nav-link"><i
                                        class="icon-note"></i> <span class="hidden-xs">Cevaplar</span></a>
                            </li>
                        </ul>
                        <div class="tab-content p-3">
                            <div class="tab-pane active show" id="profile">
                                <h5 class="mb-3">Hakkımda</h5>
                                <div class="row">
                                    {!! $item->bio !!}
                                </div>
                                <!--/row-->
                            </div>
                            <div class="tab-pane" id="messages">
                                <table class="table table-hover table-striped">
                                    <tbody>
                                    @forelse($questions as $question)
                                        <tr>
                                            <td>
                                                <a href="{{ route('front.question.question_detail',$question->seflink) }}">{{ $question->baslik }}</a>
                                                @if($question->cozumlenme==1)
                                                    <small class="badge badge-success" style="float: right; background-color: green;">Çözümlendi</small>
                                                @else
                                                    <small class="badge bage-primary" style="float: right; background-color: #3ebafa;">Çözüm Bekliyor</small>
                                                @endif
                                                <span
                                                    class="d-flex justify-content-end text-danger">{{ date('d.m.Y',strtotime($question->created_at)) }}</span>
                                            </td>
                                        </tr>
                                    @empty
                                    @endforelse
                                    </tbody>
                                </table>

                                <div class="d-flex justify-content-center">
                                    {{ $questions->links() }}
                                </div>
                            </div>
                            <div class="tab-pane" id="edit">
                                <table class="table table-hover table-striped">
                                    <tbody>
                                    @forelse($comments as $comment)
                                        <tr>
                                            <td>

                                                <a href="{{ route('front.question.question_detail',optional($comment->question)->seflink) }}">{{ \Illuminate\Support\Str::limit(strip_tags($comment->comment),20,"...") }}</a>
                                                <span
                                                    class="d-flex justify-content-end text-danger">{{ date('d.m.Y',strtotime($comment->created_at)) }}</span>
                                            </td>
                                        </tr>
                                    @empty
                                    @endforelse
                                    </tbody>
                                </table>

                                <div class="d-flex justify-content-center">
                                    {{ $comments->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('content2')
    <a href="{{ route('front.question.index') }}" class="tt-btn-create-topic">
    <span class="tt-icon">
        <svg>
          <use xlink:href="#icon-create_new"></use>
        </svg>
    </span>
    </a>
@endsection

@section('js')

@endsection
