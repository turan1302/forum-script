<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable()->comment('Beğenme, Yorum yapma vs');
            $table->integer('userId')->nullable()->comment('Gönderici ID');
            $table->integer('receiverUserId')->nullable()->comment('Alıcı ID');
            $table->text('text')->nullable();
            $table->tinyInteger('isRead')->nullable()->default(0)->comment("0 ise Okunmamış, 1 ise okunmuş");
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
        Schema::dropIfExists('notifications');
    }
}
