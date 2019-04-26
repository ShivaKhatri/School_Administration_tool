<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->increments('id');
            $table->string('firstName');
            $table->string('middleName')->nullable();
            $table->string('LastName');
            $table->string('gender');
            $table->date('dob');
            $table->string('role');
            $table->string('address');
            $table->string('profilePic')->nullable();
            $table->string('remark')->nullable();
            $table->string('classTeacher_id')->nullable();
            $table->string('sectionTeacher_id')->nullable();
            $table->string('mobile_no');
            $table->string('phone_no')->nullable();
            $table->string('email')->unique();
            $table->tinyInteger('status')->default(0);
            $table->string('password');
            $table->rememberToken();
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
        Schema::drop('staff');
    }
}
