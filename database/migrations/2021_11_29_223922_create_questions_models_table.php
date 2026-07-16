<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('baslik')->nullable();
            $table->string('seflink')->nullable();
            $table->longText('text')->nullable();
            $table->text('tags')->nullable()->comment('soru etiketleri');
            $table->text('tags_slug')->nullable()->comment('etiketlerin slug kısmı');
            $table->tinyInteger('status')->default(0)->nullable()->comment("0 ise Pasif, 1 ise Aktif");
            $table->tinyInteger('cozumlenme')->default(0)->nullable()->comment("soruda eğer doğru cevap seçilmiş ise bu kısım 1 olur. Soru kapanır yorum verilmez");
            $table->integer('goruntulenme')->default(0)->nullable()->comment("soru goruntulenme sayısı");
            $table->string('ip_address')->nullable();
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
        Schema::dropIfExists('questions');
    }
}
