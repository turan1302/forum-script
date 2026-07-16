<?php

namespace App\Http\Controllers\back\users;

use App\Http\Controllers\Controller;
use App\Http\Requests\back\UserRequest;
use App\Models\CommentsModel;
use App\Models\LikeCommentModel;
use App\Models\LikeQuestionModel;
use App\Models\QuestionCategoryModel;
use App\Models\QuestionsModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class indexController extends Controller
{
    public function index()
    {
        return view('back.users.index');
    }

    // YORUMLARI CAGIRALIM (TUM YORUMLAR)
    public function data()
    {
        $query = User::where("id", "!=", auth()->user()->id);

        $data = DataTables::of($query)
            ->addIndexColumn()
            ->orderColumn("sira", function ($query) {
                $query->orderBy("id", "desc");
            })
            ->addColumn("sira", function ($query) {
                return "<i class='fa fa-bars'></i>";
            })
            ->addColumn("status", function ($query) {
                $checkedStatus = ($query->durum == 1) ? 'checked' : '';
                return "<label class='switch'>
                        <input type='checkbox' class='isActive' data-url=" . route("back.uyeler.isActiveSetter", $query->id) . " $checkedStatus>
                         <span class='slider round'></span>
                        </label>";
            })
            ->addColumn("approve", function ($query) {
                $checkedStatus = ($query->uyelik_onay == 1) ? 'checked' : '';
                return "<label class='switch'>
                        <input type='checkbox' class='isApprove' data-url=" . route("back.uyeler.isApproveSetter", $query->id) . " $checkedStatus>
                         <span class='slider round'></span>
                        </label>";
            })
            ->addColumn("actions", function ($query) {
                $edit = "<a href=" . route('back.uyeler.edit', $query->id) . " class='btn btn-primary btn-sm'><i class='fa fa-edit'></i></a>";
                $update = "<button type='button' class='btn btn-danger btn-sm isDelete' data-url=" . route('back.uyeler.delete', $query->id) . "><i class='fa fa-times'></i></button>";

                return $edit . " " . $update;
            })
            ->rawColumns(["sira", "status", "approve", "actions"])
            ->make(true);
        return $data;
    }

    // DURUM GUNCELLEME ISLEMI
    public function isActiveSetter(User $item)
    {
        $data = (\request()->post('data') == "true") ? 1 : 0;
        $item->update(array(
            "durum" => $data
        ));
    }

    // UYELIK ONAY GUNCELLEME ISLEMI
    public function isApproveSetter(User $item)
    {
        $data = (\request()->post('data') == "true") ? 1 : 0;
        $item->update(array(
            "uyelik_onay" => $data,
            "aktiflestirme_kod" => ""
        ));
    }


    // YORUM KISMINI SILME ISLEMMINI GERCEKLESTIRLEIM
    public function delete(User $item)
    {
        $id = $item->id;

        // KULLANICIYI SILME ISLEMI
        $item->forceDelete();

        // SORU SILME KISMINI AYARLAYALIM
        $sorular = QuestionsModel::where("user_id", $id)->get();
        foreach ($sorular as $soru) {
            QuestionCategoryModel::where("question_id", $soru->id)->forceDelete();
            LikeQuestionModel::where(array(
                "question_id" => $soru->id,
                "user_id" => $id
            ))->forceDelete();
        }

        QuestionsModel::where("user_id", $id)->forceDelete();

        // YORUM SILME KISMI AYARLAMSI
        $yorumlar = CommentsModel::where("user_id", $id)->get();
        foreach ($yorumlar as $yorum) {
            LikeCommentModel::where(array(
                "user_id" => $id,
                "comment_id" => $yorum
            ))->forceDelete();
        }

        CommentsModel::where("user_id", $id)->forceDelete();
    }


    // KULLANICI KISMI AYARLAMASI
    public function edit(User $item)
    {
        return view('back.users.edit', compact('item'));
    }


    // KULLANICI GUNCELLEME KISMI AYARLAMASI
    public function update(UserRequest $request, User $item)
    {
        // KULLANICI MAIL KISMINA BAKALIM
        if ($item->email != $request->email){
            $request->validate(array(
                "email" => "unique:users|email"
            ), array(), array(
                "email" => "E-Mail"
            ));
        }

        // NICK KISMINA BAKALIM
        if ($item->nickname != $request->nickname){
            $request->validate(array(
                "nickname" => "unique:users"
            ), array(), array(
                "nickname" => "Kullanıcı Adı"
            ));
        }

        // PHONE KISMINA BAKALIM
        if ($item->phone != $request->phone){
            $request->validate(array(
                "phone" => "unique:users"
            ), array(), array(
                "phone" => "Telefon Numarası"
            ));
        }


        $data = $request->except("_token");
        $data['password'] = Hash::make($request->password);

        // SIFRE KISMI
        if ($item->password != Hash::make($request->password)){
            $data['password'] = Hash::make($request->password);
        }

        // FOTOĞRAF KISMI
        $data['photo'] = $item->photo;
        if ($request->hasFile('photo')){
            if ($item->photo != "" && File::exists('storage/'.$item->photo)){
                File::delete("storage/".$item->photo);
            }

            $file = $request->file('photo');
            $file_name = Str::slug($item->name)."-".time().".".$file->getClientOriginalExtension();
            $data['photo'] = $file->storeAs("kullanici",$file_name);
        }

        $sonuc = $item->update($data);

        if ($sonuc){
            $alert = [
                "type" => "success",
                "title" => "Başarılı",
                "message" => "İşlem Başarılı"
            ];
        }else{
            $alert = [
                "type" => "error",
                "title" => "Hata",
                "message" => "İşlem Başarısız"
            ];
        }

        return redirect()->back()->with($alert);
    }

}
