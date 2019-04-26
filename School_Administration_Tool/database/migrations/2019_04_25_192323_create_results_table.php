<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('class_id');
            $table->integer('sec_id')->nullable();
            $table->integer('exam_id');
            $table->integer('obtained_mark')->default(0);
            $table->integer('total_mark')->default(0);
            $table->integer('session')->default(date('Y'));
            $table->integer('mark_id');
            $table->integer('student_id');
            $table->integer('published')->default(0);
            $table->string('grade')->default('N');
            $table->string('gradeDescription');
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
        Schema::dropIfExists('results');
    }
}
