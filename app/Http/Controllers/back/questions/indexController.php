<?php

namespace App\Http\Controllers\back\questions;

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
        return view('back.questions.index');
    }

    // CEVAPLANMIŞ SORULAR
    public function cevaplanmis(){
        return view('back.questions.cevaplanmis');
    }

    // COZUMLENMIS SORULAR
    public function cozumlenmis(){
        return view('back.questions.cozumlenmis');
    }

    // SORULARI CAGIRALIM (TUM SORULAR ICIN)
    public function data()
    {
        $query = QuestionsModel::select(["questions.*","users.name"])->leftJoin("users", "users.id", "=", "questions.user_id");  // ŞART BURADAN

        $data = DataTables::of($query)
            ->addIndexColumn()
            ->orderColumn("sira", function ($query) {
                $query->orderBy("questions.id", "desc");
            })
            ->addColumn("sira", function ($query) {
                return "<i class='fa fa-bars'></i>";
            })
            ->addColumn("kullanici", function ($query) {
                return $query->name;
            })
            ->addColumn("status", function ($query) {
                $checkedStatus = ($query->status == 1) ? 'checked' : '';
                return "<label class='switch'>
                        <input type='checkbox' class='isActive' data-url=" . route("back.questions.isActiveSetter", $query->id) . " $checkedStatus>
                         <span class='slider round'></span>
                        </label>";
            })
            ->addColumn("close", function ($query) {
                $checkedStatus = ($query->cozumlenme == 1) ? 'checked' : '';
                return "<label class='switch'>
                        <input type='checkbox' class='isClose' data-url=" . route("back.questions.isCloseSetter", $query->id) . " $checkedStatus>
                         <span class='slider round'></span>
                        </label>";
            })
            ->addColumn("like",function ($query){
                return LikeQuestionModel::where(array(
                    "question_id" => $query->id,
                    "status" => 1
                ))->count();
            })
            ->addColumn("disslike",function ($query){
                return LikeQuestionModel::where(array(
                    "question_id" => $query->id,
                    "status" => -1
                ))->count();

            })
            ->addColumn("actions", function ($query) {
                $edit = "<a href=" . route('back.questions.show', $query->id) . " class='btn btn-primary btn-sm'><i class='fa fa-eye'></i></a>";
                $update = "<button type='button' class='btn btn-danger btn-sm isDelete' data-url=" . route('back.questions.delete', $query->id) . "><i class='fa fa-times'></i></button>";

                return $edit . " " . $update;
            })
            ->rawColumns(["sira","status","close", "actions"])
            ->make(true);
        return $data;
    }

    // SORULARI CAGIRALIM (CEVAPLANMIS)
    public function data_cevaplanmis(){
        $query = QuestionsModel::select(["questions.*","users.name"])->join("comments","comments.question_id","=","questions.id")->leftJoin("users", "users.id", "=", "questions.user_id")->where(array(
            "comments.status" => 1
        ))->orderBy("questions.created_at","desc");  // ŞART BURADAN

        $data = DataTables::of($query)
            ->addIndexColumn()
            ->orderColumn("sira", function ($query) {
                $query->orderBy("questions.id", "desc");
            })
            ->addColumn("sira", function ($query) {
                return "<i class='fa fa-bars'></i>";
            })
            ->addColumn("kullanici", function ($query) {
                return $query->name;
            })
            ->addColumn("status", function ($query) {
                $checkedStatus = ($query->status == 1) ? 'checked' : '';

                return "<label class='switch'>
                        <input type='checkbox' class='isActive' data-url=" . route("back.questions.isActiveSetter", $query->id) . " $checkedStatus>
                         <span class='slider round'></span>
                        </label>";
            })
            ->addColumn("close", function ($query) {
                $checkedStatus = ($query->cozumlenme == 1) ? 'checked' : '';
                return "<label class='switch'>
                        <input type='checkbox' class='isClose' data-url=" . route("back.questions.isCloseSetter", $query->id) . " $checkedStatus>
                         <span class='slider round'></span>
                        </label>";
            })
            ->addColumn("like",function ($query){
                return LikeQuestionModel::where(array(
                    "question_id" => $query->id,
                    "status" => 1
                ))->count();
            })
            ->addColumn("disslike",function ($query){
                return LikeQuestionModel::where(array(
                    "question_id" => $query->id,
                    "status" => -1
                ))->count();

            })
            ->addColumn("actions", function ($query) {
                $edit = "<a href=" . route('back.questions.show', $query->id) . " class='btn btn-primary btn-sm'><i class='fa fa-eye'></i></a>";
                $update = "<button type='button' class='btn btn-danger btn-sm isDelete' data-url=" . route('back.questions.delete', $query->id) . "><i class='fa fa-times'></i></button>";

                return $edit . " " . $update;
            })
            ->rawColumns(["sira","status","close", "actions"])
            ->make(true);
        return $data;
    }

    // SORULARI CAGIRALIM (COZUMLENMIS)
    public function data_cozumlenmis(){
        $query = QuestionsModel::select(["questions.*","users.name"])->join("comments","comments.question_id","=","questions.id")->leftJoin("users", "users.id", "=", "questions.user_id")->where(array(
            "comments.is_true" => 1
        ))->orderBy("questions.created_at","desc");  // ŞART BURADAN

        $data = DataTables::of($query)
            ->addIndexColumn()
            ->orderColumn("sira", function ($query) {
                $query->orderBy("questions.id", "desc");
            })
            ->addColumn("sira", function ($query) {
                return "<i class='fa fa-bars'></i>";
            })
            ->addColumn("kullanici", function ($query) {
                return $query->name;
            })
            ->addColumn("status", function ($query) {
                $checkedStatus = ($query->status == 1) ? 'checked' : '';

                return "<label class='switch'>
                        <input type='checkbox' class='isActive' data-url=" . route("back.questions.isActiveSetter", $query->id) . " $checkedStatus>
                         <span class='slider round'></span>
                        </label>";
            })
            ->addColumn("close", function ($query) {
                $checkedStatus = ($query->cozumlenme == 1) ? 'checked' : '';
                return "<label class='switch'>
                        <input type='checkbox' class='isClose' data-url=" . route("back.questions.isCloseSetter", $query->id) . " $checkedStatus>
                         <span class='slider round'></span>
                        </label>";
            })
            ->addColumn("like",function ($query){
                return LikeQuestionModel::where(array(
                    "question_id" => $query->id,
                    "status" => 1
                ))->count();
            })
            ->addColumn("disslike",function ($query){
                return LikeQuestionModel::where(array(
                    "question_id" => $query->id,
                    "status" => -1
                ))->count();

            })
            ->addColumn("actions", function ($query) {
                $edit = "<a href=" . route('back.questions.show', $query->id) . " class='btn btn-primary btn-sm'><i class='fa fa-eye'></i></a>";
                $update = "<button type='button' class='btn btn-danger btn-sm isDelete' data-url=" . route('back.questions.delete', $query->id) . "><i class='fa fa-times'></i></button>";

                return $edit . " " . $update;
            })
            ->rawColumns(["sira","status","close", "actions"])
            ->make(true);
        return $data;
    }

    // DURUM GUNCELLEME ISLEMI
    public function isActiveSetter(QuestionsModel $item)
    {
        $data = (\request()->post('data') == "true") ? 1 : 0;
        $item->update(array(
            "status" => $data
        ));
    }

    // SORU KAPATMA ACMA ISLEMINI YAZALIM
    public function isCloseSetter(QuestionsModel $item){
        $data = (\request()->post('data') == "true") ? 1 : 0;
        $item->update(array(
            "cozumlenme" => $data
        ));
    }

    // GUNCELLEME SAYFASI
    public function show(QuestionsModel $item)
    {
        $categories = KategoriModel::where("durum", 1)->orderBy("sira", "asc")->get();
        return view('back.questions.show', compact('item','categories'));
    }

    // SİLME İSLEMI
    public function delete(QuestionsModel $item)
    {
        $id = $item->id;

        // SORUYU SILELIM
        $item->forceDelete();

        // YORUMLARINI SILELIM
        $yorumlar = CommentsModel::where(array(
            "question_id" => $id
        ))->get();

        foreach ($yorumlar as $yorum){
            LikeCommentModel::where(array(
                "comment_id" => $yorum->id
            ))->forceDelete();
        }

        CommentsModel::where(array(
            "question_id" => $id
        ))->forceDelete();

        // SORU BEGENILERINI SILELIM
        LikeQuestionModel::where(array(
            "question_id" => $id
        ))->forceDelete();

        // SORUNUN KATEGORILEIRNI SILELIM
        QuestionCategoryModel::where(array(
            "question_id" => $id
        ))->forceDelete();

        // KAYITLI SORULARI SILELIM
        SaveQuestionModel::where(array(
            "question_id" => $id
        ))->forceDelete();
    }

}
