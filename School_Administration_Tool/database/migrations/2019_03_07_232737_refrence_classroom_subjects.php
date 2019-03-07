<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RefrenceClassroomSubjects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('classroom_subject', function (Blueprint $table) {
            $table->unsignedInteger('class_id')->nullable()->change();
            $table->foreign('class_id')->references('id')->on('class_rooms')->onDelete('cascade');

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
        Schema::table('classroom_subject', function (Blueprint $table) {
            $table->dropForeign('classroom_subject_class_id_foreign');
            $table->dropColumn('class_id');

            $table->dropForeign('classroom_subject_sub_id_foreign');
            $table->dropColumn('sub_id');

        });
    }
}
