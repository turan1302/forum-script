<?php

namespace App\Http\Controllers\back\notifications;

use App\Http\Controllers\Controller;
use App\Models\CommentsModel;
use App\Models\LikeCommentModel;
use App\Models\NotificationModel;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class indexController extends Controller
{
    public $userData;

    public function index()
    {
        return view('back.notifications.index');
    }

    // YORUMLARI CAGIRALIM (TUM YORUMLAR)
    public function data()
    {
        $query = NotificationModel::orderBy("id","desc");


        $data = DataTables::of($query)
            ->addIndexColumn()
            ->orderColumn("sira", function ($query) {
                $query->orderBy("id", "desc");
            })
            ->addColumn("sira", function ($query) {
                return "<i class='fa fa-bars'></i>";
            })
            ->addColumn("gonderici",function ($query){
                return $query->gonderici_user->name;
            })
            ->addColumn("alici",function ($query){
                return $query->alici_user->name;
            })
            ->addColumn("status", function ($query) {
                $checkedStatus = ($query->isRead == 1) ? '<p class="badge badge-success">Okunmuş</p>' : '<p class="badge badge-success">Okunmamış</p>';
                return $checkedStatus;
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
                $update = "<button type='button' class='btn btn-danger btn-sm isDelete' data-url=" . route('back.notifications.delete', $query->id) . "><i class='fa fa-times'></i></button>";

                return $update;
            })
            ->rawColumns(["sira", "status", "actions"])
            ->make(true);
        return $data;
    }


    // YORUM KISMINI SILME ISLEMMINI GERCEKLESTIRLEIM
    public function delete(NotificationModel $item)
    {
        $item->forceDelete();
    }
}
