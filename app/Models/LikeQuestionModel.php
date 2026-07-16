<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LikeQuestionModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];
    protected $table = "like_questions";

    /*** SORU KISMI **/
    public function questions(){
        return $this->belongsTo(QuestionsModel::class,'question_id','id');
    }
}
