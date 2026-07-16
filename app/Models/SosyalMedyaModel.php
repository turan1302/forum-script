<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SosyalMedyaModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "sosyal_medya";
    protected $guarded = [];
}
