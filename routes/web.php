<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

// SİTE BAKIM MODU KISMI ROUTER
Route::get('/site-bakimda', function () {
    if (\App\Models\SettingsModel::find(1)->site_durum=="0"){
        return view('bakim.index');
    }else{
        return redirect()->route('front.index');
    }
})->name('site-bakim');

// ON KISIM AYARLAMASI
Route::group(['prefix' => '/', 'namespace' => 'front', 'as' => 'front.'], function () {

    // ANASAYFA KISMI
    Route::get('', [\App\Http\Controllers\front\home\indexController::class, 'index'])->name('index')->middleware('gzip');

    // SOSYAL MEDYA LINKLERI KISMI
    Route::get('sosyal-medya/{sm_anahtar?}',[\App\Http\Controllers\front\home\indexController::class,'sosyal_medya'])->name('sosyal_medya')->middleware('gzip');

    // CEVAPLANMIŞ  SORULAR
    Route::get('answered-questions', [\App\Http\Controllers\front\home\indexController::class, 'cevaplanmis'])->name('cevaplanmis')->middleware('gzip');

    // ÇÖZÜMLENMİŞ SORULAR
    Route::get('solved-questions', [\App\Http\Controllers\front\home\indexController::class, 'cozumlenmis'])->name('cozumlenmis')->middleware('gzip');

    // KULLANICI LISTESI
    Route::get('user-list', [\App\Http\Controllers\front\home\indexController::class, 'user_list'])->name('user_list')->middleware('gzip');

    // KAYIT OLMA KISMI
    Route::group(['prefix' => 'signup', 'namespace' => 'signup', 'as' => 'signup.','middlware'=>'gzip'], function () {
        Route::get('', [\App\Http\Controllers\front\signup\indexController::class, 'index'])->name('index');
        Route::post('', [\App\Http\Controllers\front\signup\indexController::class, 'store'])->name('store');
    });

    // LOGIN KISMI AYARLAMASI
    Route::group(['prefix' => 'signin', 'namespace' => 'signin', 'as' => 'signin.','middlware'=>'gzip'], function () {
        Route::get('', [\App\Http\Controllers\front\signin\indexController::class, 'index'])->name('index');
        Route::post('', [\App\Http\Controllers\front\signin\indexController::class, 'login'])->name('login');

        Route::get('logout', [\App\Http\Controllers\front\signin\indexController::class, 'logout'])->name('logout');
    });

    // SORU SORMA KISMI AYARLAMA ISLEMINI YAPALIM
    Route::group(['prefix' => 'question', 'namespace' => 'question', 'as' => 'question.'], function () {
        // SORU SORMA KISMINI ENGELLEME ISLEMINI YAPALIM. EĞER GİRİŞ VARSA GİRECEK ZATEN
        Route::group(['middleware' => 'frontAuth'], function () {
            Route::get('', [\App\Http\Controllers\front\question\indexController::class, 'index'])->name('index')->middleware('gzip');
            Route::post('ask-question', [\App\Http\Controllers\front\question\indexController::class, 'ask_question'])->name('ask_question')->middleware('gzip');
        });

        // SORU DETAYI KISMI
        Route::get('{slug}', [\App\Http\Controllers\front\question\indexController::class, 'question_detail'])->name('question_detail');

        // SORU ETIKETINDEN O ETIKETE AIT SORULARA ULASMA KISMINI AYARLAYALIM
        Route::get('tags/{tag}',[\App\Http\Controllers\front\question\indexController::class,'tag_detail'])->name('tag_detail')->middleware('gzip');

        Route::group(['middleware' => 'frontAuth'], function () {

            // SORU GUNCELLEME SAYFASI
            Route::get('edit-question/{slug}', [\App\Http\Controllers\front\question\indexController::class, 'edit_question'])->name('edit_question')->middleware('gzip');
            Route::patch('update-question/{item}', [\App\Http\Controllers\front\question\indexController::class, 'update_question'])->name('update_question');

            // SOEU KAYDETME KISMI
            Route::post('save-question/{item}', [\App\Http\Controllers\front\question\indexController::class, 'save_question'])->name('save_question');

            // SORU SILME KISMI
            Route::get('delete-question/{item}', [\App\Http\Controllers\front\question\indexController::class, 'delete_question'])->name('delete_question');

            // SORU BEĞENME VE BEĞENMEME ISLEMI
            Route::get('like-or-disslike-question/{item}', [\App\Http\Controllers\front\question\indexController::class, 'like_or_disslike_question'])->name('like_or_disslike_question');

            // SORU YORUM YAPMA KISMI
            Route::post('do-comment/{item}', [\App\Http\Controllers\front\question\indexController::class, 'do_comment'])->name('do_comment');

            // YORUM BEĞENME VE BEĞENMEME KISMI
            Route::post('like-or-disslike-comment', [\App\Http\Controllers\front\question\indexController::class, 'like_or_disslike_comment'])->name('like_or_disslike_comment');

            // YORUM SILME KISMI
            Route::post('delete-comment', [\App\Http\Controllers\front\question\indexController::class, 'delete_comment'])->name('delete_comment');

            // YORUM ONAYLAMA ISLEMI
            Route::post('comment-do-correct', [\App\Http\Controllers\front\question\indexController::class, 'isCorrect'])->name('isCorrect');
        });

    });

    // SORU ARAMA KISMI
    Route::get('search', [\App\Http\Controllers\front\search\indexController::class, 'search'])->name('search')->middleware('gzip');;

    // PROFIL DUZENLEME ISLEMINI YAPALIM
    Route::group(['prefix' => 'account', 'namespace' => 'hesabim', 'as' => 'hesabim.', 'middleware' => ['frontAuth','gzip']], function () {
        Route::get('info', [\App\Http\Controllers\front\account\indexController::class, 'index'])->name('index');
        Route::patch('info-update/{item}', [\App\Http\Controllers\front\account\indexController::class, 'update'])->name('info_update');

        // KAYITLI SORULARIMIZI GORME KISMI
        Route::get('save-questions', [\App\Http\Controllers\front\account\indexController::class, 'save_questions'])->name('save_questions');

        // BILDIRIMLER KISMINI GORME ISLEMINI YAZALIM
        Route::get('notifications', [\App\Http\Controllers\front\account\indexController::class, 'notifications'])->name('notifications');
    });

    // KATEGORILER KISMI
    Route::group(['prefix' => 'categories', 'namespace' => 'category', 'as' => 'category.','middleware'=>'gzip'], function () {
        Route::get('', [\App\Http\Controllers\front\category\indexController::class, 'index'])->name('index');
        // KATEGORIYE AIT SORU KISMI
        Route::get('{slug}', [\App\Http\Controllers\front\category\indexController::class, 'category_detail'])->name('category_detail');
    });

    // HAKKINDA SAYFASI
    Route::get('about',[\App\Http\Controllers\front\home\indexController::class,'about'])->name('about')->middleware('gzip');
    Route::get('privacy',[\App\Http\Controllers\front\home\indexController::class,'privacy'])->name('privacy')->middleware('gzip');
    Route::get('kvkk',[\App\Http\Controllers\front\home\indexController::class,'kvkk'])->name('kvkk')->middleware('gzip');

    // KULLANICI DETAY SAYFASI
    Route::get('user/{nickname}', [\App\Http\Controllers\front\question\indexController::class, 'user_detail'])->name('user_detail')->middleware('gzip');

    // KULLANICI UYELIK AKTIFLESTIRME ISLEMI
    Route::get('membership-activation/{item}/{code}',[\App\Http\Controllers\front\signup\indexController::class,'activation'])->name('activation');

});


// ADMIN KISMI AYARLAMSI
Route::group(['prefix' => 'panelim', 'namespace' => 'back', 'as' => 'back.'], function () {

    // LOGIN BURADAN OLACAK
    Route::group(['prefix' => 'login', 'namespace' => 'login', 'as' => 'login.'], function () {
        Route::get('', [\App\Http\Controllers\back\login\indexController::class, 'index'])->name('index');
        Route::post('do-login', [\App\Http\Controllers\back\login\indexController::class, 'do_login'])->name('do_login');
        Route::get('logout', [\App\Http\Controllers\back\login\indexController::class, 'logout'])->name('logout');
    });

    // ANASAYFA BURADAN OLACAK
    Route::group(['prefix' => '', 'namespace' => 'home', 'as' => 'home.', 'middleware' => ['auth', 'isAdmin']], function () {
        Route::get('', [\App\Http\Controllers\back\home\indexController::class, 'index'])->name('index');
    });


    // KATEGORİLER KISMINI AYARLAMA ISLEMI
    Route::group(['prefix' => 'kategoriler', 'namespace' => 'categories', 'as' => 'categories.', 'middleware' => ['auth', 'isAdmin']], function () {
        Route::get('', [\App\Http\Controllers\back\categories\indexController::class, 'index'])->name('index');
        Route::get('create', [\App\Http\Controllers\back\categories\indexController::class, 'create'])->name('create');
        Route::post('store', [\App\Http\Controllers\back\categories\indexController::class, 'store'])->name('store');
        Route::group(['prefix' => '{item}'], function () {
            Route::patch('update-status', [\App\Http\Controllers\back\categories\indexController::class, 'isActiveSetter'])->name('isActiveSetter');
            Route::get('edit', [\App\Http\Controllers\back\categories\indexController::class, 'edit'])->name('edit');
            Route::patch('update', [\App\Http\Controllers\back\categories\indexController::class, 'update'])->name('update');
            Route::delete("delete", [\App\Http\Controllers\back\categories\indexController::class, 'delete'])->name('delete');
        });

        // SIRALAMA ISLEMI
        Route::patch('rank-setter', [\App\Http\Controllers\back\categories\indexController::class, 'rankSetter'])->name('rankSetter');

        // KATEGORİLERİ BURADAN ÇAĞIRCAZ
        Route::post('data', [\App\Http\Controllers\back\categories\indexController::class, 'data'])->name('data');
    });

    // SOSYAL MEDYA KISMI AYARLANMASI
    Route::group(['prefix' => 'sosyal-medya', 'namespace' => 'sm', 'as' => 'sm.', 'middleware' => ['auth', 'isAdmin']], function () {
        Route::get('', [\App\Http\Controllers\back\sm\indexController::class, 'index'])->name('index');
        Route::get('create', [\App\Http\Controllers\back\sm\indexController::class, 'create'])->name('create');
        Route::post('store', [\App\Http\Controllers\back\sm\indexController::class, 'store'])->name('store');
        Route::group(['prefix' => '{item}'], function () {
            Route::patch('update-status', [\App\Http\Controllers\back\sm\indexController::class, 'isActiveSetter'])->name('isActiveSetter');
            Route::get('edit', [\App\Http\Controllers\back\sm\indexController::class, 'edit'])->name('edit');
            Route::patch('update', [\App\Http\Controllers\back\sm\indexController::class, 'update'])->name('update');
            Route::delete("delete", [\App\Http\Controllers\back\sm\indexController::class, 'delete'])->name('delete');
        });

        // SIRALAMA ISLEMI
        Route::patch('rank-setter', [\App\Http\Controllers\back\sm\indexController::class, 'rankSetter'])->name('rankSetter');

        // KATEGORİLERİ BURADAN ÇAĞIRCAZ
        Route::post('data', [\App\Http\Controllers\back\sm\indexController::class, 'data'])->name('data');
    });

    // BANNER KISMINI AYARLAMA ISLEMI
    Route::group(['prefix' => 'bannerlar', 'namespace' => 'banner', 'as' => 'banners.', 'middleware' => ['auth', 'isAdmin']], function () {
        Route::get('', [\App\Http\Controllers\back\banner\indexController::class, 'index'])->name('index');
        Route::get('create', [\App\Http\Controllers\back\banner\indexController::class, 'create'])->name('create');
        Route::post('store', [\App\Http\Controllers\back\banner\indexController::class, 'store'])->name('store');
        Route::group(['prefix' => '{item}'], function () {
            Route::patch('update-status', [\App\Http\Controllers\back\banner\indexController::class, 'isActiveSetter'])->name('isActiveSetter');
            Route::get('edit', [\App\Http\Controllers\back\banner\indexController::class, 'edit'])->name('edit');
            Route::patch('update', [\App\Http\Controllers\back\banner\indexController::class, 'update'])->name('update');
            Route::delete("delete", [\App\Http\Controllers\back\banner\indexController::class, 'delete'])->name('delete');
        });

        // SIRALAMA ISLEMI
        Route::patch('rank-setter', [\App\Http\Controllers\back\banner\indexController::class, 'rankSetter'])->name('rankSetter');

        // KATEGORİLERİ BURADAN ÇAĞIRCAZ
        Route::post('data', [\App\Http\Controllers\back\banner\indexController::class, 'data'])->name('data');
    });

    // SORULAR KISMI AYARLAMASI
    Route::group(['prefix' => 'sorular', 'namespace' => 'questions', 'as' => 'questions.', 'middleware' => ['auth', 'isAdmin']], function () {
        Route::get('', [\App\Http\Controllers\back\questions\indexController::class, 'index'])->name('index');
        // CEVAPLANMIS SORULARIN GETIRILME ISLEMI
        Route::get('cevaplanmis', [\App\Http\Controllers\back\questions\indexController::class, 'cevaplanmis'])->name('cevaplanmis');
        // COZUMLENMIS SORULARIN GETIRILME ISLEMI
        Route::get('cozumlenmis', [\App\Http\Controllers\back\questions\indexController::class, 'cozumlenmis'])->name('cozumlenmis');

        Route::group(['prefix' => '{item}'], function () {
            Route::patch('update-status', [\App\Http\Controllers\back\questions\indexController::class, 'isActiveSetter'])->name('isActiveSetter');
            Route::patch('close-status', [\App\Http\Controllers\back\questions\indexController::class, 'isCloseSetter'])->name('isCloseSetter');
            Route::get('show', [\App\Http\Controllers\back\questions\indexController::class, 'show'])->name('show');
            Route::delete("delete", [\App\Http\Controllers\back\questions\indexController::class, 'delete'])->name('delete');
        });

        // TUM SORULARI BURADAN ÇAĞIRCAZ
        Route::post('data', [\App\Http\Controllers\back\questions\indexController::class, 'data'])->name('data');
        // CEVAPLANMIS SORULAR
        Route::post('cevaplanmis-data', [\App\Http\Controllers\back\questions\indexController::class, 'data_cevaplanmis'])->name('data_cevaplanmis');
        // COZUMLENMIS SORULAR
        Route::post('cozumlenmis-data', [\App\Http\Controllers\back\questions\indexController::class, 'data_cozumlenmis'])->name('data_cozumlenmis');
    });

    // YORUMLAR KISMI AYARLAMASI
    Route::group(['prefix' => 'yorumlar', 'namespace' => 'comments', 'as' => 'comments.', 'middleware' => ['auth', 'isAdmin']], function () {
        Route::get('', [\App\Http\Controllers\back\comments\indexController::class, 'index'])->name('index');
        // YAYINLANMIŞ SORULARIN GETIRILME ISLEMI
        Route::get('yayinlanmis', [\App\Http\Controllers\back\comments\indexController::class, 'yayinlanmis'])->name('yayinlanmis');
        // YAYINLANMAMIŞ SORULARIN GETIRILME ISLEMI
        Route::get('yayinlanmamis', [\App\Http\Controllers\back\comments\indexController::class, 'yayinlanmamis'])->name('yayinlanmamis');
        // DOĞRU CEVAP OLARAK SECILMIS


        Route::group(['prefix' => '{item}'], function () {
            Route::patch('update-status', [\App\Http\Controllers\back\comments\indexController::class, 'isActiveSetter'])->name('isActiveSetter');
            Route::get('show', [\App\Http\Controllers\back\comments\indexController::class, 'show'])->name('show');
            Route::delete("delete", [\App\Http\Controllers\back\comments\indexController::class, 'delete'])->name('delete');
        });

        // TUM YORUMLARI BURADAN ÇAĞIRCAZ
        Route::post('data', [\App\Http\Controllers\back\comments\indexController::class, 'data'])->name('data');
        // CEVAPLANMIS SORULAR
        Route::post('yayinlanmis-data', [\App\Http\Controllers\back\comments\indexController::class, 'data_yayinlanmis'])->name('data_yayinlanmis');
        // COZUMLENMIS SORULAR
        Route::post('yayinlanmamis-data', [\App\Http\Controllers\back\comments\indexController::class, 'data_yayinlanmamis'])->name('data_yayinlanmamis');
    });

    // BILDIRIMLER KISMI
    Route::group(['prefix' => 'bildirimler', 'namespace' => 'notifications', 'as' => 'notifications.', 'middleware' => ['auth', 'isAdmin']], function () {
        Route::get('', [\App\Http\Controllers\back\notifications\indexController::class, 'index'])->name('index');
        Route::group(['prefix' => '{item}'], function () {
            Route::delete("delete", [\App\Http\Controllers\back\notifications\indexController::class, 'delete'])->name('delete');
        });

        // TUM YORUMLARI BURADAN ÇAĞIRCAZ
        Route::post('data', [\App\Http\Controllers\back\notifications\indexController::class, 'data'])->name('data');
    });


    // UYELER KISMI
    Route::group(['prefix' => 'uyeler', 'namespace' => 'users', 'as' => 'uyeler.', 'middleware' => ['auth', 'isAdmin']], function () {
        Route::get('', [\App\Http\Controllers\back\users\indexController::class, 'index'])->name('index');
        Route::group(['prefix' => '{item}'], function () {
            Route::patch('update-status', [\App\Http\Controllers\back\users\indexController::class, 'isActiveSetter'])->name('isActiveSetter');
            Route::patch('approve', [\App\Http\Controllers\back\users\indexController::class, 'isApproveSetter'])->name('isApproveSetter');

            Route::get('edit', [\App\Http\Controllers\back\users\indexController::class, 'edit'])->name('edit');
            Route::patch('update', [\App\Http\Controllers\back\users\indexController::class, 'update'])->name('update');

            Route::delete("delete", [\App\Http\Controllers\back\users\indexController::class, 'delete'])->name('delete');

        });
        // TUM YORUMLARI BURADAN ÇAĞIRCAZ
        Route::post('data', [\App\Http\Controllers\back\users\indexController::class, 'data'])->name('data');
    });

    // AYARLAR KISMI
    Route::group(['prefix' => 'ayarlar', 'namespace' => 'settings', 'as' => 'settings.', 'middleware' => ['auth', 'isAdmin']], function () {
        Route::get('', [\App\Http\Controllers\back\settings\indexController::class, 'index'])->name('index');

        // HAKKIMDA SAYFASI
        Route::get('hakkinda',[\App\Http\Controllers\back\settings\indexController::class,'about'])->name('about');

        // GİZLİLİK POLİTİKASI SAYFASI
        Route::get('gizlilik-politikasi',[\App\Http\Controllers\back\settings\indexController::class,'privacy'])->name('privacy');

        // KVKK KAPSAMI
        Route::get('kvkk-kapsami',[\App\Http\Controllers\back\settings\indexController::class,'kvkk'])->name('kvkk');

        Route::group(['prefix' => '{item}'], function () {
            Route::patch('', [\App\Http\Controllers\back\settings\indexController::class, 'update'])->name('update');
            Route::patch('about-update',[\App\Http\Controllers\back\settings\indexController::class,'about_update'])->name('about_update');
            Route::patch('privacy-update',[\App\Http\Controllers\back\settings\indexController::class,'privacy_update'])->name('privacy_update');
            Route::patch('kvkk-update',[\App\Http\Controllers\back\settings\indexController::class,'kvkk_update'])->name('kvkk_update');
        });
    });

    // PROFİL AYARLARI KISMI
    Route::group(['prefix' => 'profil', 'namespace' => 'profile', 'as' => 'profile.', 'middleware' => ['auth', 'isAdmin']], function () {
        Route::get('', [\App\Http\Controllers\back\profile\indexController::class, 'index'])->name('index');
        Route::group(['prefix'=>'{item}'],function (){
            Route::patch('',[\App\Http\Controllers\back\profile\indexController::class,'update'])->name('update'); // GENEL GUNCELLEME KISMI
            Route::patch('about-update',[\App\Http\Controllers\back\settings\indexController::class,'about_update'])->name('about_update');
        });
    });
});
