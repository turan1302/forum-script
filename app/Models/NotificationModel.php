<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotificationModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];
    protected $table = "notifications";

    /*** GONDERICI KISMI **/
    public function gonderici_user(){
        return $this->belongsTo(User::class,'userId','id');
    }

    /*** ALICI KISMI ****/
    public function alici_user(){
        return $this->belongsTo(User::class,'receiverUserId','id');
    }
}
