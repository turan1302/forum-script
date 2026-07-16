<?php

namespace App\Http\Controllers\front\account;

use App\Http\Controllers\Controller;
use App\Http\Requests\front\AccountRequest;
use App\Models\BannerModel;
use App\Models\NotificationModel;
use App\Models\SaveQuestionModel;
use App\Models\SettingsModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class indexController extends Controller
{
    public function __construct()
    {
        if (SettingsModel::find(1)->site_durum == "0") {
            return redirect()->route('site-bakim')->send();
        }
    }

    // HESABIM KISMI
    public function index(){
        return view('front.account.index');
    }

    // BILGI GUNCELLEME KISMI
    public function update(AccountRequest $request,User $item){
        // RESIM KONTROL ETTIRME
        $photo = auth()->user()->photo;
        if ($request->hasFile('photo')){
            if (auth()->user()->photo != "" && File::exists("storage/".auth()->user()->photo)){
                File::delete("storage/".auth()->user()->photo);
            }

            $file = $request->file('photo');
            $file_name = Str::slug(auth()->user()->name)."-".time();
            Image::make($file)->encode('webp', 90)->resize(512, 512)->save(public_path("storage/kullanici/" . $file_name . ".webp"));
            $photo = "kullanici/".$file_name.".webp";
        }

        // PASSWOWRD AYARLAMA KISMI
        $pasword = ($request->password!="") ? Hash::make($request->password) : $item->password;

        $data = $request->except("_token");
        $data['photo'] = $photo;
        $data['password'] = $pasword;

        $sonuc = $item->update($data);

        if ($sonuc){
            return redirect()->back()->with(array(
                "type" => "success",
                "title" => "Başarılı",
                "message" => "Hesap Bilgileriniz Başarıyla Güncellendi"
            ));
        }else{
            return redirect()->back()->with(array(
                "type" => "error",
                "title" => "Hata",
                "message" => "Hesap Bilgileriniz Güncellenirken Hata Oluştu"
            ));
        }
    }

    // KAYITLI SORULARIMIZIN GORUNTULENME KISMI
    public function save_questions(){

        $banner = BannerModel::where("banner_anahtar","kayıt")->first();

        $items = SaveQuestionModel::leftJoin("questions","questions.id","=","save_questions.question_id")->where(array(
            "questions.status" => 1,
            "save_questions.user_id" => auth()->user()->id
        ))->orderBy("save_questions.id","desc")->paginate(10);


        return view('front.account.save_questions',compact('items','banner'));
    }

    // BILDIRIMLER KISMININ AYARLANMA ISLEMINI YAZALIM
    public function notifications(){
        NotificationModel::where(array(
            "receiverUserId" => auth()->user()->id
        ))->update(array(
            "isRead" => 1
        ));

        $banner = BannerModel::where("banner_anahtar","bildirimler")->first();

        $items = NotificationModel::where(array(
            "receiverUserId" => auth()->user()->id
        ))->orderBy("id","desc")->paginate(10);

        return view('front.account.notifications',compact('items','banner'));
    }
}
