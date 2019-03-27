<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGuardiansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guardians', function (Blueprint $table) {
            $table->increments('id');
            $table->string('firstName');
            $table->string('middleName')->nullable();
            $table->string('LastName');
            $table->string('gender');
            $table->date('dob');
            $table->string('address');
            $table->string('profilePic')->nullable();

            $table->string('remark')->nullable();
            $table->string('relation');
            $table->string('occupation')->nullable();
            $table->string('mobile_no');
            $table->string('phone_no')->nullable();
            $table->string('email')->unique();
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
        Schema::drop('guardians');
    }
}
