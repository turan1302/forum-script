<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaveQuestionModel extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = "save_questions";

    /*** QUESTION RELATIONSHIP **/
    public function question(){
        return $this->belongsTo(QuestionsModel::class,'question_id','id');
    }
}
