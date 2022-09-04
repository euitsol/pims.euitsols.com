<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_infos', function (Blueprint $table) {
            $table->id();
            $table->string('student_id')->unique()->nullable();
            $table->string('name');
            $table->string('father_name');
            $table->string('mother_name');
            $table->string('present_address');
            $table->string('parmanent_address');
            $table->string('email')->nullable();
            $table->string('gender');
            $table->string('phone');
            $table->string('phone2')->nullable();
            $table->string('dob');
            $table->string('Quota')->nullable();
            $table->string('nationality');
            $table->string('blood_group_name')->nullable();
            $table->unsignedBigInteger('departments_id');
            $table->string('registration_no')->nullable();
            $table->string('cgpa')->nullable();
            $table->string('reg_card')->nullable();
            $table->string('marksheet')->nullable();
            $table->string('photo')->nullable();
            $table->string('result')->nullable();
            $table->string('session')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
            $table->foreign('departments_id')->references('id')->on("departments")->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_infos');
    }
}