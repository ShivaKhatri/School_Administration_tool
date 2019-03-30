<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RefrenceGuardianStudent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('guardian_student', function (Blueprint $table) {
            $table->unsignedInteger('guard_id')->nullable()->change();
            $table->foreign('guard_id')->references('id')->on('guardians')->onDelete('cascade');

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
        Schema::table('guardian_student', function (Blueprint $table) {
            $table->dropForeign('guardian_student_guard_id_foreign');

            $table->dropForeign('guardian_student_student_id_foreign');

        });
    }
}
