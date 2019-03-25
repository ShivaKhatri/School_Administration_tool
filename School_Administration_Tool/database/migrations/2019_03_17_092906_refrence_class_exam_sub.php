<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RefrenceClassExamSub extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('class_exam_sub', function (Blueprint $table) {
            $table->unsignedInteger('class_id')->nullable()->change();
            $table->foreign('class_id')->references('id')->on('class_rooms')->onDelete('cascade');

            $table->unsignedInteger('exam_id')->nullable()->change();
            $table->foreign('exam_id')->references('id')->on('exams')->onDelete('cascade');

            $table->unsignedInteger('sub_id')->nullable()->change();
            $table->foreign('sub_id')->references('id')->on('subjects')->onDelete('cascade');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('class_exam_sub', function (Blueprint $table) {
            $table->dropForeign('class_exam_sub_class_id_foreign');

            $table->dropForeign('class_exam_sub_exam_id_foreign');


            $table->dropForeign('class_exam_sub_sub_id_foreign');


        });
    }
}
