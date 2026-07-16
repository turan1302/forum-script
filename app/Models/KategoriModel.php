<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class KategoriModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];
    protected $table = "kategoriler";

    // SLUG MUTATOR
    public function setKatAdiAttribute($value){
        $this->attributes['kat_adi'] = $value;
        $this->attributes['kat_slug'] = Str::slug($value);
    }

    /** QUESTION CATEGORY RELATIONSHIP **/
    public function question_category(){
        return $this->hasMany(QuestionCategoryModel::class,'category_id','id');
    }
}
