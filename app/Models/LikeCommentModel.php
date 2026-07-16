<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LikeCommentModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];
    protected $table = "like_comments";

    /** COMMENT KISMI **/
    public function comments(){
        return $this->belongsTo(CommentsModel::class,'comment_id','id');
    }
}
