<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nickname')->nullable();
            $table->string('name');
            $table->string('photo')->nullable();
            $table->date('birthday')->nullable()->comment('Kullanıcının Doğum Tarihi');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('website')->nullable();
            $table->string('job')->nullable();
            $table->text('bio')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->tinyInteger('email_gizle')->default(1)->nullable()->comment("0 ise Pasif, 1 ise Aktif yapar");
            $table->tinyInteger('telefon_gizle')->default(1)->nullable()->comment("0 ise Pasif, 1 ise Aktif yapar");
            $table->tinyInteger('profil_foto_gizle')->default(1)->nullable()->comment("0 ise Pasif, 1 ise Aktif yapar");
            $table->tinyInteger('durum')->default(1)->nullable()->comment("0 ise Pasif, 1 ise Aktif Üye");
            $table->tinyInteger('uyelik_onay')->default(0)->nullable()->comment('Üyelik Mailini Aktifleştirince Burası 1 Olacak');
            $table->string('aktiflestirme_kod')->nullable()->comment('Kisi uye olunca burada rastgele karakter atama islemi olacak');
            $table->integer('dogru_yanit_sayisi')->default(0)->nullable()->comment("kullanıcının verdiği toplam doğru yanıtların sayısını tutacak");
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
