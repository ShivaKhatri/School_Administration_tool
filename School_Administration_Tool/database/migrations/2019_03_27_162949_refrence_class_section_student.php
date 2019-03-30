<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RefrenceClassSectionStudent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('class_section_student', function (Blueprint $table) {
            $table->unsignedInteger('class_id')->nullable()->change();
            $table->foreign('class_id')->references('id')->on('class_rooms')->onDelete('cascade');

            $table->unsignedInteger('section_id')->nullable()->change();
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');

            $table->unsignedInteger('student_id')->nullable()->change();
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('class_section_student', function (Blueprint $table) {
            $table->dropForeign('class_section_student_class_id_foreign');

            $table->dropForeign('class_section_student_section_id_foreign');

            $table->dropForeign('class_section_student_student_id_foreign');

        });
    }
}
