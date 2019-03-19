<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RefrenceClassSection extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('classroom_section', function (Blueprint $table) {
            $table->unsignedInteger('class_id')->nullable()->change();
            $table->foreign('class_id')->references('id')->on('class_rooms')->onDelete('cascade');

            $table->unsignedInteger('sec_id')->nullable()->change();
            $table->foreign('sec_id')->references('id')->on('sections')->onDelete('cascade');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('classroom_section', function (Blueprint $table) {
            $table->dropForeign('classroom_section_class_id_foreign');

            $table->dropForeign('classroom_section_sec_id_foreign');

        });
    }
}
