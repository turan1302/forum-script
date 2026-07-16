<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLikeQuestionModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('like_questions', function (Blueprint $table) {
            $table->id();
            $table->integer('question_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->tinyInteger('status')->nullable()->comment("1 beğenme, -1 beğenmeme");
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
        Schema::dropIfExists('like_questions');
    }
}
