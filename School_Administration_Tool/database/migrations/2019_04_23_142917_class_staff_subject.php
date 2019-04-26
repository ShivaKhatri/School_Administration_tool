<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ClassStaffSubject extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_staff_subject', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('subject_id')->nullable();
            $table->integer('class_id')->nullable();
            $table->integer('sec_id')->nullable();
            $table->integer('staff_id')->nullable();
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
        Schema::dropIfExists('class_staff_subject');
    }
}
