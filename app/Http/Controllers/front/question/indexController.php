<?php

namespace App\Http\Controllers\front\question;

use App\Helper\myHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\front\AskQuestionRequest;
use App\Http\Requests\front\DoCommentRequest;
use App\Mail\YeniSoruGeldi;
use App\Mail\YeniYorumGeldi;
use App\Models\BannerModel;
use App\Models\CommentsModel;
use App\Models\KategoriModel;
use App\Models\LikeCommentModel;
use App\Models\LikeQuestionModel;
use App\Models\QuestionCategoryModel;
use App\Models\QuestionsModel;
use App\Models\SaveQuestionModel;
use App\Models\SettingsModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class indexController extends Controller
{
    public function __construct()
    {
        if (SettingsModel::find(1)->site_durum == "0") {
            return redirect()->route('site-bakim')->send();
        }
    }

    public $item;  // QUERY BUILDER KSIMI ICIN YAZALIM

    public function index()
    {
        $banner = BannerModel::where("banner_anahtar","sorusor")->first();


        $categories = KategoriModel::where("durum", 1)->orderBy("sira", "asc")->get();
        return view('front.question.index', compact('categories','banner'));
    }

    // SORU SORMA KISMI
    public function ask_question(AskQuestionRequest $request)
    {
        $data = $request->except("_token");

        // ETIKETLER KISMI LIMIT AYARLAMA ISLEMINI GERCEKLESTIRELIM
        if (!empty($request->post('tags'))) {
            $tags = explode(",", $request->post('tags'));
            if (count($tags) > 5) {
                return redirect()->back()->with(array(
                    "type" => "error",
                    "title" => "Hata",
                    "message" => "En Fazla 5 Etiket Girme Hakkınız Vardır"
                ));
            }
        }

        $data['user_id'] = \auth()->user()->id;
        $data['ip_address'] = $request->getClientIp();
        unset($data['categories']);

        $askQuestion = QuestionsModel::create($data);

        if ($askQuestion) {
            // KATEGORI EKLEMESI
            foreach ($request->post('categories') as $k => $v) {
                QuestionCategoryModel::create(array(
                    "question_id" => $askQuestion->id,
                    "category_id" => $v
                ));
            }

            // MAIL GONDERME KISMI
            Mail::to("m.fatihbagcivan@hotmail.com")->send(new YeniSoruGeldi());
            Mail::to("cimec61@gmail.com")->send(new YeniSoruGeldi());

            return redirect()->route('front.index')->with(array(
                "type" => "success",
                "title" => "Başarılı",
                "message" => "Sorunuz Başarıyla Oluşturuldu. Admin tarafından onaylandıktan sonra sitede yayınlanacaktır"
            ));
        } else {
            return redirect()->route('front.question.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "message" => "Bir hata oluştu. Lütfen daha sonra tekrar deneyiniz"
            ));
        }
    }

    // SORU GUNCELLEME SAYFASI
    public function edit_question($slug)
    {
        $banner = BannerModel::where("banner_anahtar","soruduzelt")->first();

        $item = QuestionsModel::with('question_category')->where(array(
            "seflink" => $slug,
            "status" => 1,
            "user_id" => \auth()->user()->id
        ))->firstOrFail();


        $categories = KategoriModel::where("durum", 1)->orderBy("sira", "asc")->get();
        return view('front.question.edit', compact('categories', 'item','banner'));
    }

    // SORU KAYDETME KISMI
    public function save_question(QuestionsModel $item)
    {
        $kontrol = SaveQuestionModel::where(array(
            "question_id" => $item->id,
            "user_id" => \auth()->user()->id
        ))->first();

        if (!empty($kontrol)) {
            SaveQuestionModel::where(array(
                "question_id" => $item->id,
                "user_id" => \auth()->user()->id
            ))->forceDelete();
        } else {
            SaveQuestionModel::create(array(
                "question_id" => $item->id,
                "user_id" => \auth()->user()->id
            ));
        }
    }

    // SORU SILME KISMI
    public function delete_question(QuestionsModel $item)
    {
        // SORUYU CIDDEN BIZ MI YAYINLADIK
        if ($item->user_id == \auth()->user()->id) {
            // SORUYU SILELIM
            $item->forceDelete();

            // LIKE QUESTION SECIMLERINI SILELIM
            LikeQuestionModel::where(array(
                "question_id" => $item->id
            ))->forceDelete();

            // QUESTION CATEGORY
            QuestionCategoryModel::where(array(
                "question_id" => $item->id
            ))->forceDelete();

            $comments = CommentsModel::where(array(
                "question_id" => $item->id
            ));

            foreach ($comments as $comment) {
                LikeCommentModel::where(array(
                    "id" => $comment->id
                ))->forceDelete();
            }

            // YORUMLARI DA SILELIM
            CommentsModel::where(array(
                "question_id" => $item->id
            ))->forceDelete();

            // KAYITLI SORULARDAN DA SILELIM
            SaveQuestionModel::where(array(
                "question_id" => $item->id
            ))->forceDelete();

            echo 1;
        } else {
            echo 2;
        }
    }


    // SORU GUNCELLEME KISMI
    public function update_question(AskQuestionRequest $request, QuestionsModel $item)
    {
        // SORUYU GERCEKTEN BU KULLANICI MI SORDU ?
        if ($item->user_id == \auth()->user()->id) {
            $data = $request->except("_token");

            // ETIKETLER KISMI LIMIT AYARLAMA ISLEMINI GERCEKLESTIRELIM
            if (!empty($request->post('tags'))) {
                $tags = explode(",", $request->post('tags'));
                if (count($tags) > 5) {
                    return redirect()->back()->with(array(
                        "type" => "error",
                        "title" => "Hata",
                        "message" => "En Fazla 5 Etiket Girme Hakkınız Vardır"
                    ));
                }
            }

            $data['user_id'] = \auth()->user()->id;
            $data['ip_address'] = $request->getClientIp();
            unset($data['categories']);

            // SORUYU ONCE BI GUNCELLEYELIM
            $updateQuestion = $item->update($data);

            if ($updateQuestion) {
                // KATEGORILERI BI SIELIM
                QuestionCategoryModel::where(array(
                    "question_id" => $item->id
                ))->forceDelete();

                foreach ($request->post('categories') as $k => $v) {
                    QuestionCategoryModel::create(array(
                        "question_id" => $item->id,
                        "category_id" => $v
                    ));
                }

                return redirect()->route('front.index')->with(array(
                    "type" => "success",
                    "title" => "Başarılı",
                    "message" => "Sorunuz Başarıyla Güncellendi."
                ));

            } else {
                return redirect()->route('front.question.index')->with(array(
                    "type" => "error",
                    "title" => "Hata",
                    "message" => "Bir hata oluştu. Lütfen daha sonra tekrar deneyiniz"
                ));
            }

        } else {
            return redirect()->route('front.index')->with(array(
                "type" => "error",
                "title" => "Hata",
                "message" => "Başkasının sorusunu güncelleyemezsin seyyar"
            ));
        }
    }


    // SORU DETAY KISMI
    public function question_detail($question_seflink)
    {

        $item = QuestionsModel::with(['user', 'question_category.categories', 'question_like_disslike'])->where(array(
            ["seflink", "=", $question_seflink],
            ["status", "=", 1]
        ))->firstOrFail();

        $this->item = $item;

        // GORUNTULEME GUNCELLEME AYARI
        if (!Cookie::get($item->id)) {
            Cookie::queue($item->id, true, time() + 3600);
            $item->update(array(
                "goruntulenme" => $item->goruntulenme + 1
            ));
        }

        // YORUMLAR KISMI ALALIM
        $comments = CommentsModel::with("comment_like_disslike")->where(array(
            ["status", "=", 1],
            ["question_id", "=", $item->id],
            ["is_true", "=", 0]
        ))->orderByDesc('created_at')->get();

        // DOĞRU YANITI ALMA ISLEMINI YAPALIM
        $dogruYanit = CommentsModel::with("comment_like_disslike")->where(array(
            ["status", "=", 1],
            ["question_id", "=", $item->id],
            ["is_true", "=", 1]
        ))->first();

        // BENZER SORULARI ALALIM
        $benzer_sorular = QuestionsModel::select("questions.*")->with(['question_category.categories', 'user', 'comment'])->leftJoin("question_category", "questions.id", "question_category.question_id")
            ->where(function ($c) {
                foreach ($this->item->question_category as $category) {
                    $c->orWhere("question_category.category_id", $category->categories->id);
                }
            })
            ->where("questions.status", 1)
            ->where("questions.id", "!=", $this->item->id)
            ->inRandomOrder()->distinct()->limit(5)->get();

        $etiketler = (!empty($item->tags)) ? array_unique(explode(",", $item->tags)) : ''; // SORU ALTINDA GÖRÜNECEK ETİKETLER

        return view('front.question.detail', compact('item', 'benzer_sorular', 'comments', 'dogruYanit', 'etiketler'));
    }

    // ETIKET DETAYINDAN SORUYA ERISIM ISLEMI
    public function tag_detail($tag)
    {
        $questions = QuestionsModel::select("*", "questions.created_at as soru_paylasim")->leftJoin("question_category", "question_category.question_id", "=", "questions.id")
            ->leftJoin("users", "users.id", "=", "questions.user_id")
            ->leftJoin("kategoriler", "kategoriler.id", "=", "question_category.category_id")
            ->where(array(
                ["questions.status", "=", 1],
                ["questions.tags_slug", "like", "%" . $tag . "%"]
            ))
            ->groupBy("questions.id")
            ->orderBy("questions.id","desc")
            ->get();


        return view('front.tag.detail', compact('questions', 'tag'));
    }

    // SORUYA YORUM YAPMA KISMINI AYARLAYALIM
    public function do_comment(DoCommentRequest $request, QuestionsModel $item)
    {
        $data = $request->except("_token");
        $data['user_id'] = \auth()->user()->id;
        $data['question_id'] = $item->id;
        $data['ip_address'] = $request->getClientIp();

        $sonuc = CommentsModel::create($data);

        if ($sonuc) {

            if (\auth()->user()->id != $item->user_id) {
                $text = \auth()->user()->name . " Kullanıcısı " . strtoupper($item->baslik) . " Başlıklı Yazınıza Yorum Yazdı";
                myHelper::notification(BILDIRIM[0], \auth()->user()->id, $item->user_id, $text);
            }

            // MAIL GONDERME KISMI
            Mail::to("m.fatihbagcivan@hotmail.com")->send(new YeniYorumGeldi());
            Mail::to("cimec61@gmail.com")->send(new YeniYorumGeldi());

            return redirect()->back()->with(array(
                "type" => "success",
                "title" => "Başarılı",
                "message" => "Yanıtınız başarılı bir şekilde yapıldı. Admin tarafından onaylandıktan sonra sistemde görünecektir"
            ));

        } else {
            return redirect()->back()->with(array(
                "type" => "error",
                "title" => "Hata",
                "message" => "Bir hata oluştu. Lütfen daha sonra tekrar deneyiniz"
            ));
        }
    }

    // SORU BEĞENME VE BEĞENMEME KISMINI AYARLAYALIM
    public function like_or_disslike_question(Request $request, QuestionsModel $item)
    {
        $status = $request->status;

        // BEĞENME VE BEĞENMEME ISLEMI KONTROLUNU YAPTIRALIM
        $statusControl = LikeQuestionModel::where(array(
            ["user_id", "=", \auth()->user()->id],
            ["question_id", "=", $item->id],
        ))->first();

        if ($statusControl) {
            if ($status == $statusControl->status) {
                $result = LikeQuestionModel::where([
                    ["user_id", "=", \auth()->user()->id],
                    ["question_id", "=", $item->id],
                ])->forceDelete();
            } else {
                $result = LikeQuestionModel::where([
                    ["user_id", "=", \auth()->user()->id],
                    ["question_id", "=", $item->id],
                ])->forceDelete();

                $result = LikeQuestionModel::create([
                    "user_id" => \auth()->user()->id,
                    "question_id" => $item->id,
                    "status" => $status
                ]);

                /** BILDIRIM KISMI AYARLAMASINI YAZALIM **/
                if ($status == 1) {
                    if (\auth()->user()->id != $item->user_id) {
                        $text = \auth()->user()->name . " Kullanıcısı " . strtoupper($item->baslik) . " Başlıklı Yazınızı Beğendi";
                        myHelper::notification(BILDIRIM[1], \auth()->user()->id, $item->user_id, $text);
                    }
                } else {
                    if (\auth()->user()->id != $item->user_id) {
                        $text = \auth()->user()->name . " Kullanıcısı " . strtoupper($item->baslik) . " Başlıklı Yazınızı Beğenmedi";
                        myHelper::notification(BILDIRIM[2], \auth()->user()->id, $item->user_id, $text);
                    }
                }
            }

            if ($result) {
                echo 1;  // BAŞARILI
            } else {
                echo 2;  // BAŞARISIZ
            }

        } else {
            $result = LikeQuestionModel::create([
                "user_id" => \auth()->user()->id,
                "question_id" => $item->id,
                "status" => $status
            ]);


            if ($result) {
                echo 1;  // BAŞARILI
            } else {
                echo 2;  // BAŞARISIZ
            }

        }
    }

    // YORUM BEĞENME VE BEĞENMEME KISMINI AYARLAYALIM
    public function like_or_disslike_comment(Request $request)
    {
        $status = $request->status;
        $comment = $request->comment;


        // YORUM KONTROL ETME ISLEMINI AYARLAYALIM
        $commentControl = LikeCommentModel::where(array(
            ["comment_id", "=", $comment],
            ["user_id", "=", \auth()->id()],
        ))->first();

        if ($commentControl) {
            // BEĞENME VE BEĞENMEME ISLEMI KONTROLUNU YAPTIRALIM
            $statusControl = LikeCommentModel::where(array(
                ["user_id", "=", \auth()->user()->id],
                ["comment_id", "=", $comment],
            ))->first();


            if ($status == $statusControl->status) {
                $result = LikeCommentModel::where([
                    ["user_id", "=", \auth()->user()->id],
                    ["comment_id", "=", $comment],
                ])->forceDelete();
            } else {
                $result = LikeCommentModel::where([
                    ["user_id", "=", \auth()->user()->id],
                    ["comment_id", "=", $comment],
                ])->forceDelete();

                $result = LikeCommentModel::create([
                    "user_id" => \auth()->user()->id,
                    "comment_id" => $comment,
                    "status" => $status
                ]);
            }

            if ($result) {
                echo 1;  // BAŞARILI
            } else {
                echo 2;  // BAŞARISIZ
            }

        } else {
            $result = LikeCommentModel::create([
                "user_id" => \auth()->user()->id,
                "comment_id" => $comment,
                "status" => $status
            ]);
        }
    }

    // YORUM SILME KISMI AYARLAMA ISLEMINI YAPALIM
    public function delete_comment(Request $request)
    {
        $comment = $request->comment;

        // YORUM KONTROL KISMI
        $commentControl = CommentsModel::where([
            ["id", "=", $comment],
            ["user_id", "=", \auth()->user()->id]
        ])->first();

        if ($commentControl) {
            // LIKE COMMENT TABLOSUNDA VARSA ORADAN SILELIM
            $result = LikeCommentModel::where(array(
                "comment_id" => $comment
            ))->forceDelete();

            $result2 = CommentsModel::where(array(
                "id" => $comment
            ))->forceDelete();

            if ($result && $result2) {
                echo 1; // BAŞARILI
            } else {
                echo 2; // BAŞARISIZ
            }

        }

    }

    // DOĞRU YANITI SECME KISMI AYARLAMASI
    public function isCorrect(Request $request)
    {
        // DATALARI ALALIM
        $question = $request->question;
        $comment = $request->comment;

        $questionControl = QuestionsModel::where(array(
            ["id", "=", $question],
            ["status", "=", 1]
        ))->first();

        if ($questionControl) {
            // YORUM KONTROL ISLEMINI AYARLAYALIM
            $commentControl = CommentsModel::where(array(
                ["question_id", "=", $question],
                ["id", "=", $comment],
                ["status", "=", 1]
            ))->first();

            if ($commentControl) {
                // DOGRU YANIT OLARAK GUNCELLEME ISLEMLERINE GECISI YAPALIM
                $dogruYanitSifirla = CommentsModel::where(array(
                    ["question_id", "=", $question],
                ))->update(array(
                    "is_true" => 0
                ));

                $dogruYanitGuncelle = CommentsModel::where(array(
                    ["question_id", "=", $question],
                    ["id", "=", $comment]
                ))->update(array(
                    "is_true" => 1
                ));

                // SORUYU KAPATALIM BU KSIMDAN DA
                QuestionsModel::where(array(
                    "id" => $question
                ))->update(array(
                    "cozumlenme" => 1  // DOĞRU YANIT SECILINCE SORUYU KAPATALIM
                ));

                // KULLANICI DOĞRU YANIT KISMININ GUNCELLENMESINI GERCEKLESTIRELIM
                User::where(array(
                    "id" => $commentControl->user_id
                ))->increment('dogru_yanit_sayisi');


                if ($dogruYanitSifirla && $dogruYanitGuncelle) {
                    echo 1;
                } else {
                    echo 2;
                }

            } else {
                echo 2;
            }
        } else {
            echo 2;  // BAŞARISIZ
        }

    }


    /******* KULLANICI DETAY KISMI AYARLAMASI *****/
    public function user_detail($nickname)
    {
        $item = User::where("nickname", $nickname)->firstOrFail();
        $questions = QuestionsModel::where(array(
            "user_id" => $item->id,
            "status" => 1
        ))->orderByDesc("id")->paginate(10);
        $comments = CommentsModel::with("question")->where(array(
            "user_id" => $item->id,
            "status" => 1
        ))->orderByDesc("id")->paginate(2);
        return view('front.question.profile', compact('item', 'questions', 'comments'));
    }
}
