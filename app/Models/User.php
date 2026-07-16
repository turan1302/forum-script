<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'nickname',
        'name',
        'photo',
        'birthday',
        'email',
        'phone',
        'website',
        'job',
        'bio',
        'password',
        "email_gizle",
        "telefon_gizle",
        "profil_foto_gizle",
        'durum',
        'uyelik_onay',
        "aktiflestirme_kod"
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getAuthPassword()
    {
        return $this->password;
    }

    // OTOMATIK OLARAK KULLANICI ADI TANIMLAMA ISLEMINI AYARLADIK
    public function setNameAttribute($value){
        $this->attributes['name'] = $value;
        $this->attributes['nickname'] = Str::slug($value)."-".time();
    }

    /*** QUESTION KISMI **/
    public function question(){
        return $this->hasMany(QuestionsModel::class,'user_id','id');
    }

    /*** COMMENTS KISMI **/
    public function comment(){
        return $this->hasMany(QuestionsModel::class,'user_id',"id");
    }


    /*** BILDIRIM KISMI AYARLAMASI (GONDERICI VE ALICI) **/
    public function notification_gonderici(){
        return $this->hasMany(NotificationModel::class,'userId','id');
    }

    /**** BILDIRIM KSIMI AYARLAMASI KISMI ***/
    public function notification_alici(){
        return $this->hasMany(NotificationModel::class,'receiverUserId','id');
    }
}
