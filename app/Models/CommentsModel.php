<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommentsModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];
    protected $table = "comments";

    /*** KULLANICI KISMI **/
    public function user(){
        return $this->belongsTo(User::class,'user_id',"id");
    }

    /** QUESTION KISMI AYARLAMASI **/
    public function question(){
        return $this->belongsTo(QuestionsModel::class,'question_id',"id");
    }

    /** LIKE DISSLIKE COMMENTS KISMI **/
    public function comment_like_disslike(){
        return $this->hasMany(LikeCommentModel::class,'comment_id','id');
    }
}
