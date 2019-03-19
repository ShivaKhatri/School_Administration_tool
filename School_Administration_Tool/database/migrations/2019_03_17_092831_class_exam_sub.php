<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ClassExamSub extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_exam_sub', function (Blueprint $table) {
            $table->integer('class_id');
            $table->integer('sub_id');
            $table->integer('exam_id');
            $table->integer('full_marks');
            $table->integer('pass_marks');
            $table->date('examDate');
            $table->time('time_from');
            $table->time('time_to');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('class_exam_sub');

    }
}
