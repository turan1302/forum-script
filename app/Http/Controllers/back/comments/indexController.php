<?php

namespace App\Http\Controllers\back\comments;

use App\Http\Controllers\Controller;
use App\Models\CommentsModel;
use App\Models\KategoriModel;
use App\Models\LikeCommentModel;
use App\Models\LikeQuestionModel;
use App\Models\QuestionCategoryModel;
use App\Models\QuestionsModel;
use App\Models\SaveQuestionModel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class indexController extends Controller
{
    public function index()
    {
        return view('back.comments.index');
    }

    // YAYINLANMIŞ SORULAR
    public function yayinlanmis()
    {
        return view('back.comments.yayinlanmis');
    }

    // YAYINLANMAMIŞ SORULAR
    public function yayinlanmamis()
    {
        return view('back.comments.yayinlanmamis');
    }

    // YORUMLARI CAGIRALIM (TUM YORUMLAR)
    public function data()
    {
        $query = CommentsModel::select(["comments.*", "questions.baslik", "users.name"])->leftJoin("questions", "questions.id", "=", "comments.question_id")->leftJoin("users", "users.id", "=", "comments.user_id");

        $data = DataTables::of($query)
            ->addIndexColumn()
            ->orderColumn("sira", function ($query) {
                $query->orderBy("comments.id", "desc");
            })
            ->addColumn("sira", function ($query) {
                return "<i class='fa fa-bars'></i>";
            })
            ->addColumn("soru", function ($query) {
                return $query->baslik;
            })
            ->addColumn("kullanici", function ($query) {
                return $query->name;
            })
            ->addColumn("status", function ($query) {
                $checkedStatus = ($query->status == 1) ? 'checked' : '';
                return "<label class='switch'>
                        <input type='checkbox' class='isActive' data-url=" . route("back.comments.isActiveSetter", $query->id) . " $checkedStatus>
                         <span class='slider round'></span>
                        </label>";
            })
            ->addColumn("like", function ($query) {
                return LikeCommentModel::where(array(
                    "comment_id" => $query->id,
                    "status" => 1
                ))->count();
            })
            ->addColumn("disslike", function ($query) {
                return LikeCommentModel::where(array(
                    "comment_id" => $query->id,
                    "status" => -1
                ))->count();

            })
            ->addColumn("actions", function ($query) {
                $edit = "<a href=" . route('back.comments.show', $query->id) . " class='btn btn-primary btn-sm'><i class='fa fa-eye'></i></a>";
                $update = "<button type='button' class='btn btn-danger btn-sm isDelete' data-url=" . route('back.comments.delete', $query->id) . "><i class='fa fa-times'></i></button>";

                return $edit . " " . $update;
            })
            ->rawColumns(["sira", "status", "actions"])
            ->make(true);
        return $data;
    }

    // YAYINLANMIS YORUMLARI CEKME ISLEMINI YAPALIM
    public function data_yayinlanmis()
    {
        $query = CommentsModel::select(["comments.*", "questions.baslik", "users.name"])->leftJoin("questions", "questions.id", "=", "comments.question_id")->leftJoin("users", "users.id", "=", "comments.user_id")->where("comments.status", 1);

        $data = DataTables::of($query)
            ->addIndexColumn()
            ->orderColumn("sira", function ($query) {
                $query->orderBy("comments.id", "desc");
            })
            ->addColumn("sira", function ($query) {
                return "<i class='fa fa-bars'></i>";
            })
            ->addColumn("soru", function ($query) {
                return $query->baslik;
            })
            ->addColumn("kullanici", function ($query) {
                return $query->name;
            })
            ->addColumn("status", function ($query) {
                $checkedStatus = ($query->status == 1) ? 'checked' : '';
                return "<label class='switch'>
                        <input type='checkbox' class='isActive' data-url=" . route("back.comments.isActiveSetter", $query->id) . " $checkedStatus>
                         <span class='slider round'></span>
                        </label>";
            })
            ->addColumn("like", function ($query) {
                return LikeCommentModel::where(array(
                    "comment_id" => $query->id,
                    "status" => 1
                ))->count();
            })
            ->addColumn("disslike", function ($query) {
                return LikeCommentModel::where(array(
                    "comment_id" => $query->id,
                    "status" => -1
                ))->count();

            })
            ->addColumn("actions", function ($query) {
                $edit = "<a href=" . route('back.comments.show', $query->id) . " class='btn btn-primary btn-sm'><i class='fa fa-eye'></i></a>";
                $update = "<button type='button' class='btn btn-danger btn-sm isDelete' data-url=" . route('back.comments.delete', $query->id) . "><i class='fa fa-times'></i></button>";

                return $edit . " " . $update;
            })
            ->rawColumns(["sira", "status", "actions"])
            ->make(true);
        return $data;
    }

    // YAYINLANMAMIŞ SORULAR
    public function data_yayinlanmamis()
    {
        $query = CommentsModel::select(["comments.*", "questions.baslik", "users.name"])->leftJoin("questions", "questions.id", "=", "comments.question_id")->leftJoin("users", "users.id", "=", "comments.user_id")->where("comments.status", 0);

        $data = DataTables::of($query)
            ->addIndexColumn()
            ->orderColumn("sira", function ($query) {
                $query->orderBy("comments.id", "desc");
            })
            ->addColumn("sira", function ($query) {
                return "<i class='fa fa-bars'></i>";
            })
            ->addColumn("soru", function ($query) {
                return $query->baslik;
            })
            ->addColumn("kullanici", function ($query) {
                return $query->name;
            })
            ->addColumn("status", function ($query) {
                $checkedStatus = ($query->status == 1) ? 'checked' : '';
                return "<label class='switch'>
                        <input type='checkbox' class='isActive' data-url=" . route("back.comments.isActiveSetter", $query->id) . " $checkedStatus>
                         <span class='slider round'></span>
                        </label>";
            })
            ->addColumn("like", function ($query) {
                return LikeCommentModel::where(array(
                    "comment_id" => $query->id,
                    "status" => 1
                ))->count();
            })
            ->addColumn("disslike", function ($query) {
                return LikeCommentModel::where(array(
                    "comment_id" => $query->id,
                    "status" => -1
                ))->count();

            })
            ->addColumn("actions", function ($query) {
                $edit = "<a href=" . route('back.comments.show', $query->id) . " class='btn btn-primary btn-sm'><i class='fa fa-eye'></i></a>";
                $update = "<button type='button' class='btn btn-danger btn-sm isDelete' data-url=" . route('back.comments.delete', $query->id) . "><i class='fa fa-times'></i></button>";

                return $edit . " " . $update;
            })
            ->rawColumns(["sira", "status", "actions"])
            ->make(true);
        return $data;
    }

    // DURUM GUNCELLEME ISLEMI
    public function isActiveSetter(CommentsModel $item)
    {
        $data = (\request()->post('data') == "true") ? 1 : 0;
        $item->update(array(
            "status" => $data
        ));
    }


    // YORUM KISMINI SILME ISLEMMINI GERCEKLESTIRLEIM
    public function delete(CommentsModel $item)
    {
        $id = $item->id;

        LikeCommentModel::where(array(
            "comment_id" => $id
        ))->forceDelete();

        CommentsModel::where(array(
            "id" => $id
        ))->forceDelete();
    }


    // SORU GORUNTULEME KISMI AYARLAMASI
    public function show(CommentsModel $item)
    {
        return view('back.comments.show', compact('item'));
    }

}
