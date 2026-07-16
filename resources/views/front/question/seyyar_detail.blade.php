<div class="col-md-4 mb-3 mt-5">
    <div class="card">
        <div class="card-body">
            <div class="d-flex flex-column align-items-center text-center">
                @if($item->user->photo != "" && \Illuminate\Support\Facades\File::exists("storage/".$item->user->photo) && $item->user->profil_foto_gizle==0)
                    <img src="{{ asset('storage/'.$item->user->photo) }}" alt="{{ $item->user->name }}"
                         class="rounded-circle"
                         width="150">
                @else
                    <img src="{{ asset('storage/resim-yok.webp') }}" alt="{{ $item->user->name }}" class="rounded-circle"
                         width="150">
                @endif
                <div class="mt-3">
                    <a href="{{ route('front.user_detail',$item->user->nickname) }}" target="_blank">
                        <h4>
                            {{ $item->user->name }}
                            @if($item->user->dogru_yanit_sayisi >= 50)
                                <i class="fas fa-check-circle text-success"></i>
                            @endif
                        </h4>
                    </a>


                    <p class="text-secondary mb-1">Toplam Sorulan Soru Sayısı: {{ \App\Models\QuestionsModel::where(array(
    "user_id" => $item->user->id,
    "status" => 1
))->count() }}</p>
                    <p class="text-secondary mb-1">Toplam Verilen Cevap
                        Sayısı: {{ \App\Models\CommentsModel::where(array(
    "user_id" => $item->user->id,
    "status" => 1
))->count() }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
