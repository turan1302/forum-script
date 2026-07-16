<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_url')->nullable();
            $table->string('site_baslik')->nullable();
            $table->string('site_desc')->nullable();
            $table->string('site_keyw')->nullable();
            $table->string('site_harita')->nullable();
            $table->tinyInteger('site_harita_durum')->default(1)->comment("1 ise aktif 0 ise pasif")->nullable();
            $table->string('site_mail')->nullable();
            $table->tinyInteger('site_durum')->default(1)->comment("1 ise aktif 0 ise pasif")->nullable();
            $table->string('site_icon')->nullable();
            $table->string('site_favicon')->nullable();
            $table->text('site_hakkinda')->nullable();
            $table->text('site_gizlilik_politikasi')->nullable();
            $table->text('site_kvkk')->nullable();
            $table->string('google_dogrulama_kodu')->nullable();
            $table->string('yandex_dogrulama_kodu')->nullable();
            $table->string("bing_dogrulama_kodu")->nullable();
            $table->mediumText('analiytcs_kodu')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('settings');
    }
}
