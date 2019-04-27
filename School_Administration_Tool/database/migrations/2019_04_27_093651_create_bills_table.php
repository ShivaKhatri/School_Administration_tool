<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
//['student_id', 'guardian_id', 'paid_status','status', 'staff_id', 'total_amount','due_amount','paid_amount','session_year','paid_date','issue_date','due_date'];

            $table->increments('id');
            $table->integer('student_id');
            $table->integer('guardian_id')->nullable();
            $table->tinyInteger('paid_status')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->integer('staff_id');
            $table->integer('total_amount')->nullable();
            $table->integer('due_amount');
            $table->integer('paid_amount')->nullable();
            $table->integer('session_year');
            $table->date('paid_date')->nullable();
            $table->date('issue_date');
            $table->date('due_date');
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
        Schema::dropIfExists('bills');
    }
}
