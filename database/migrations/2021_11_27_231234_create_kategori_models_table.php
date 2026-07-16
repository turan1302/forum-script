<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKategoriModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kategoriler', function (Blueprint $table) {
            $table->id();
            $table->string('kat_adi')->nullable();
            $table->string('kat_desc')->nullable();
            $table->string('kat_keyw')->nullable();
            $table->string('kat_photo')->nullable();
            $table->string('kat_slug')->nullable();
            $table->tinyInteger('durum')->default(1)->nullable();
            $table->tinyInteger('sira')->default(0)->nullable();
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
        Schema::dropIfExists('kategoriler');
    }
}
