<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionCategoryModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];
    protected $table = "question_category";

    // SORULAR KISMI
    public function questions(){
        return $this->belongsTo(QuestionsModel::class,'question_id','id');
    }

    // KATEGORİLER KISMI
    public function categories(){
        return $this->belongsTo(KategoriModel::class,'category_id','id');
    }
}
