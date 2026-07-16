<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class QuestionsModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];
    protected $table = "questions";

    // SEFLINK MUTATOR AYARLAMASI
    public function setBaslikAttribute($value){
        $this->attributes['baslik'] = $value;
        $this->attributes['seflink'] = Str::slug($value)."-".time();
    }

    // ETIKET KISMI AYARLAMA MUTATOR
    public function setTagsAttribute($value){
        $this->attributes['tags'] = $value;
        $yazi_etiketler = explode(",",$value);
        $icerik="";
        foreach ($yazi_etiketler as $yazi){
            $icerik.=Str::slug($yazi).",";
        }
        $this->attributes['tags_slug']=substr($icerik,0,-1);
    }

    /*** KATEGORİ KISMI AYARLAMASI ***/
    public function question_category(){
        return $this->hasMany(QuestionCategoryModel::class,'question_id','id');
    }

    /** KULLANICI KISMI AYARLAMASI **/
    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    /** YORUM KISMI AYARLANMASI **/
    public function comment(){
        return $this->hasMany(CommentsModel::class,'question_id',"id");
    }

    /** BEĞENME VE BEĞENMEME AYARLAMASI **/
    public function question_like_disslike(){
        return $this->hasMany(LikeQuestionModel::class,'question_id',"id");
    }

    /** KAYIT KISMI ANALIZ ETME ISLEMI **/
    public function save_question(){
        return $this->hasMany(SaveQuestionModel::class,'question_id','id');
    }
}
